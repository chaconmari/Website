 <!DOCTYPE html>
 <html>
 <head>
 	<title>Customer</title>
 	<style type="text/css">
 	body{
 		background-color: grey;
 	}
 	h1{
 		text-align: center;
 	}
 	table {
 		border-collapse: collapse;
 		position: relative;
		margin: 0 auto;
 	}

 	td, th {
 		border: 1px solid black;
 		text-align: left;
 		padding: 8px;
 	}

 	tr:nth-child(even) {
 		background-color: #dddddd;
 	}
 </style>
</head>
<body>
	<?php 
	session_start();
	include 'nav.php';

	if (!isset($_SESSION['Admin'])) {
		die("You are not authorized to access this page");
	}
	elseif ($_SESSION['Admin'] == "Regular") {
		header("Location: customer.php");
	}

	$host='earth.cs.utep.edu';
	$user='jrosas5';
	$password='Spartanbot';
	$db='f17cs4339team14';

	$conn = mysqli_connect($host,$user,$password,$db);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$username = $_SESSION['username'];
	$type = $_SESSION['Admin'];

	$query = "SELECT * FROM users WHERE username = '$username'";
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	$row = mysqli_fetch_assoc($result);
	//print_r($row);
	echo "<h1>Welcome ".$row['First_Name']."!</h1>";

	echo "<table>
	<tr>
	<td>First Name</td>
	<td colspan='2'>".$row['First_Name']."</td>
	</tr>
	<tr>
	<td>Last Name</td>
	<td colspan='2'>".$row['Last_Name']."</td>
	</tr>
	<tr>
	<td>Username</td>
	<td colspan='2'>".$row['Username']."</td>
	</tr>
	<tr>
	<td>Password</td>
	<td>Hidden</td>
	<td><a href='changePasswd.php'>Change</a></td>
	</tr>
	<tr>
	<td>Address</td>
	<td>".$row['Address']."</td>
	<td><a href='changeAddress.php'>Change</a></td>
	</tr>
	<tr>
	<td>Zip Code</td>
	<td>".$row['Zip_Code']."</td>
	<td><a href='changeZip.php'>Change</a></td>
	</tr>
	<tr>
	<td>State</td>
	<td>".$row['State']."</td>
	<td><a href='changeState.php'>Change</a></td>
	</tr>
	<tr>
	<td colspan='3'><p style='text-align:center'><a href='delUser.php'>Delete user</a></td>
	</tr>
	<tr>
	<td colspan='3'><p style='text-align:center'><a href='adminChangeAddress.php'>Change User Address</a></td>
	</tr>
	<tr>
	<td colspan='3'><p style='text-align:center'><a href='adminChangePassword.php'>Change User Password</a></td>
	</tr>
	</table>";

	?>



</body>
</html>
