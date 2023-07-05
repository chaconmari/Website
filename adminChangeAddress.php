<?php 
include 'nav.php';

if (!isset($_SESSION['Admin'])) {
	die("You are not authorized to access this page");
}
elseif ($_SESSION['Admin'] == "Regular") {
	header("Location: customer.php");
}
else{ 
	if(isset($_POST['new']) && isset($_POST['user'])){
		
		$host='earth.cs.utep.edu';
		$user='jrosas5';
		$password='Spartanbot';
		$db='f17cs4339team14';

		$conn = mysqli_connect($host,$user,$password,$db);

		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$username = mysqli_real_escape_string($conn,$_POST['username']);
		$new = mysqli_real_escape_string($conn,$_POST['new']);

		$query = "SELECT * FROM users WHERE Username = '$username';";
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		$row = mysqli_num_rows($result);

		if($row == 1){
			$query = "UPDATE users SET Address ='$new' WHERE Username='$username';";
			$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
			echo "<p id='success'>Address updated successfully</p>";
		}
		else {
			echo "<p id='failure'>User was not found.</p>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>

	<style type="text/css">
	body{
		background-color: grey;
	}
	h1{
		text-align: center;
	}
	table{
		position: relative;
		margin: 0 auto;
	}
</style>
</head>
<body>
	<h1>Change Address</h1>
	<table>
		<form method="POST">
			<tr>
				<td><p>Username</p></td>
				<td><input type="text" name="user" required maxlength="25"></td>
			</tr>
			<tr>
				<td><p>New Address</p></td>
				<td><input type="text" name="new" required maxlength="25"></td>
			</tr>
			<tr><td colspan="2" align="center"><input type="submit" name="Submit" value="Change"></td></tr>
		</table>
	</form>
	<script
	src="https://code.jquery.com/jquery-3.2.1.js"
	integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
	crossorigin="anonymous"></script>
	<script type="text/javascript">
		
	</script>
</body>
</html>
