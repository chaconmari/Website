<?php

if (isset($_POST['username']) && isset($_POST['password'])) {
	$host='earth.cs.utep.edu';
	$user='jrosas5';
	$password='Spartanbot';
	$db='f17cs4339team14';

	$conn = mysqli_connect($host,$user,$password,$db);


	$salt = "qjsd!4";
	$username = mysqli_real_escape_string($conn,$_POST['username']);
	$passwd = mysqli_real_escape_string($conn,$_POST['password']);
	$hashed = hash('ripemd128', $salt . $username . $passwd);
    
    // Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$query = "SELECT * FROM users WHERE username = '$username' AND password = '$hashed';";

	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));

	$count = mysqli_num_rows($result);
	$row = mysqli_fetch_assoc($result);

	if ($count == 1) {
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['Admin'] = $row['Type_of_User'];
		if ($row['Type_of_User'] == "Admin") {
			header("Location: admin.php");
		}
		else{
			header("Location: customer.php");		}
	}
	else{
		echo "<p id='failure'>Username or Password is not valid.</p>";
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
	li{
		display: inline; 
	}
	body{
		padding: 0px;
		margin: 0px;
	}
	nav{
		position: relative;
		background-color: black;
	}
	nav a{
		color: white;
	}
	nav ul{
		margin-bottom: 0px;
	}
	nav li{
		padding-left: 20px;
	}
	nav form{
		position: absolute;
		bottom: 0px;
		right: 0px;
	}
	#success{
		margin-top: 0px;
		margin-bottom: 0px;
		background-color: green;
		text-align: center;
	}
	#failure{
		margin-top: 0px;
		margin-bottom: 0px; 
		background-color: red;
		text-align: center;
	}
</style>
</head>
<body>
	<nav>
		<img src="https://upload.wikimedia.org/wikipedia/en/thumb/b/b6/University_of_Texas_at_El_Paso_logo.svg/1280px-University_of_Texas_at_El_Paso_logo.svg.png" width="100" height="70">
		<ul style="float: right;">
			<li><a href="DisplayParts.php">Home</a></li>
			<?php
			session_start();
			if (!isset($_SESSION['username'])) {
			echo "<li><a href='register.php'>Register</a></li>";
		}
		else{
			    if ($_SESSION['Admin'] == "Admin"){
                    echo "<li><a href='admin.php'>Admin</a></li>";
                }
                else{
                    echo "<li><a href='customer.php'>Customer</a></li>";
                }
            echo "<li><a href='logout.php'>Log Out</a></li>";
        }
			?>
		</ul>
		<?php
		if (!isset($_SESSION['username'])) {
		echo "<form method='POST'>
			<label style='color: white;'>Username: </label>
			<input type='text' name='username'>
			<label style='color: white;'>Password: </label>
			<input type='password' name='password'>
			<input type='submit' name='Submit'>
		</form>";
	}
		?>
	</nav>
</body>
</html>
