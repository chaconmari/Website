<?php
include 'nav.php';

if (isset($_POST['first']) && isset($_POST['last']) && isset($_POST['username']) && isset($_POST['passwd']) && isset($_POST['address']) && isset($_POST['zip']) && isset($_POST['state'])) {

	$host='earth.cs.utep.edu';
	$user='jrosas5';
	$password='Spartanbot';
	$db='f17cs4339team14';

	$conn = mysqli_connect($host,$user,$password,$db);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}


	$first = mysqli_real_escape_string($conn,$_POST['first']);
	$last = mysqli_real_escape_string($conn,$_POST['last']);
	$username = mysqli_real_escape_string($conn,$_POST['username']);
	$password = mysqli_real_escape_string($conn,$_POST['passwd']);
	$address = mysqli_real_escape_string($conn,$_POST['address']);
	$zip = mysqli_real_escape_string($conn,$_POST['zip']);
	$state = mysqli_real_escape_string($conn,$_POST['state']);

	$salt = "qjsd!4";
	$password = $salt . $username . $password;
	$password =  hash('ripemd128', $password);

	//Generate special ID
	$query = "SELECT max(id) FROM users";
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	$lastID = mysqli_fetch_row($result)[0];
	$specialID = "user" . $lastID;

	//Check if Username already exist.
	$query = "SELECT * FROM users where Username = '$username'";
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	$duplicate = mysqli_num_rows($result);

	if ($duplicate) {
		echo "<p id='failure'>Username already exist</p>";
	}
	else{
		$query = "INSERT INTO users (Special_Id, First_Name, Last_Name,Username,Password,Type_of_User,Address,Zip_Code,State) VALUES ('$specialID', '$first', '$last', '$username', '$password', 'Regular','$address','$zip','$state');";
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		if ($result) {
			echo "<p id='success'>User registered successfully</p>";
		}
		else{
			echo "<p id='failure'>There was an error. Please try again.</p>";
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<style type="text/css">
	body{
		background-color: grey;
	}
	table{
		position: relative;
		margin: 0 auto;
	}
	h1{
		text-align: center;
	}
</style>
</head>
<body>
	<h1>Register</h1>
	<table>
		<form method="POST">
			<tr>
				<td><p>First Name</p></td>
				<td><input type="text" name="first" required maxlength="25"></td>
			</tr>
			<tr>
				<td><p>Last Name </p></td>
				<td><input type="text" name="last" required maxlength="25"></td>
			</tr>
			<tr>
				<td><p>Username</p></td>
				<td><input type="text" name="username" required maxlength="25"></td>
			</tr>
			<tr>
				<td><p>Password</p></td>
				<td><input type="password" name="passwd" id="paswd" required maxlength="25"></td>
			</tr>
			<tr>
				<td><p>Confirm Password</p></td>
				<td><input type="password" name="confirm" id="confirm" required maxlength="25"></td>
			</tr>
			<tr>
				<td><p>Address</p></td>
				<td><input type="text" name="address" required maxlength="25"></td>
			</tr>
			<tr>
				<td><p>Zip Code</p></td>
				<td><input type="text" id="zip" name="zip" required maxlength="11"></td>
			</tr>
			<tr>
				<td><p>State</p></td>
				<td><input type="text" id="state" name="state" maxlength="2" required></td>
			</tr>
			<tr><td colspan="2" align="center"><input type="submit" name="Submit"></td></tr>
		</table>
	</form>
	<script
	src="https://code.jquery.com/jquery-3.2.1.js"
	integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
	crossorigin="anonymous"></script>
	<script type="text/javascript">
		var numberReg = /[0-9]/;
		$("#zip").focusout(function(){
			if(numberReg.test($("#zip").val()) && $){
				return true;
			}
			else{
				alert("Zip Code can only be numbers");
				return false;
			}
		});
        var stateReg = /[A-Z]/;
        $("#state").focusout(function(){
            if(stateReg.test($("#state").val()) && $){
                return true;
            }
            else{
                alert("State is only two capital letters.");
                return false;
            }
        });


		$("#confirm").focusout(function(){
			if ($('#paswd').val() == $('#confirm').val()){
				return true;
			}
			else{
				alert("Passwords do not match");
				return false;
			}
		});
		$("#confirm").focusout(function(){
			if ($('#paswd').val() == $('#confirm').val()){
				return true;
			}
			else{
				alert("Passwords do not match");
				return false;
			}
		});
	</script>
</body>
</html>
