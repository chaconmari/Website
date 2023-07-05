<?php 
include 'nav.php';

if (!isset($_SESSION['username'])) {
		die("You are not authorized to access this page");
	}

if (isset($_POST['old']) && isset($_POST['new']) && isset($_POST['confirm'])) {
	if ($_POST['new'] == $_POST['confirm']) {

		$host='earth.cs.utep.edu';
		$user='jrosas5';
		$password='Spartanbot';
		$db='f17cs4339team14';

		$conn = mysqli_connect($host,$user,$password,$db);

		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$username = $_SESSION['username'];
		$old = mysqli_real_escape_string($conn,$_POST['old']);
		$new = mysqli_real_escape_string($conn,$_POST['new']);
		$confirm = mysqli_real_escape_string($conn,$_POST['confirm']);

		$salt = "qjsd!4";
		$old = $salt . $username . $old;
		$old =  hash('ripemd128', $old);

		$new = $salt . $username . $new;
		$new = hash('ripemd128', $new);

		$query = "SELECT Password FROM users WHERE username = '$username';";
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		$row = mysqli_fetch_array($result);

		if ($old == $row[0]) {
			$query = "UPDATE users SET Password ='$new' WHERE Password='$row[0]';";
			$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
			echo "<p id='success'>Password updated successfully</p>";
		}
		else{
			echo "<p id='failure'>Old password did not match</p>";
		}
	}

	else{
		echo "<p id='failure'>New passwords did not match.</p>";
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
	<h1>Change Password</h1>
	<table>
		<form method="POST">
			<tr>
				<td><p>Old Password</p></td>
				<td><input type="password" name="old" required maxlength="25"></td>
			</tr>
			<tr>
				<td><p>New Password</p></td>
				<td><input type="password" id="new" name="new" required maxlength="25"></td>
			</tr>
			<tr>
				<td><p>Confirm New Password</p></td>
				<td><input type="password" id="confirm" name="confirm" required maxlength="25"></td>
			</tr>
			<tr><td colspan="2" align="center"><input type="submit" name="Submit" value="Change"></td></tr>
		</table>
	</form>
	<script
	src="https://code.jquery.com/jquery-3.2.1.js"
	integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
	crossorigin="anonymous"></script>
	<script type="text/javascript">
		$("#confirm").focusout(function(){
			if ($('#new').val() == $('#confirm').val()){
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
