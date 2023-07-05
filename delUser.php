<?php 
include 'nav.php';

if (!isset($_SESSION['Admin'])) {
	die("You are not authorized to access this page");
}
elseif ($_SESSION['Admin'] == "Regular") {
	header("Location: customer.php");
}
else{

	if (isset($_POST['user'])) {

		$host='earth.cs.utep.edu';
		$user='jrosas5';
		$password='Spartanbot';
		$db='f17cs4339team14';

		$conn = mysqli_connect($host,$user,$password,$db);

		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$user = mysqli_real_escape_string($conn,$_POST['user']);

		$query = "SELECT * FROM users WHERE Username = '$user';";
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		$row = mysqli_num_rows($result);


		if ($row == 1) {
			$user = mysqli_real_escape_string($conn,$_POST['user']);
			$query = "DELETE FROM users WHERE Username = '$user'";
			$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
			echo "<p id='success'>User was deleted successfully</p>";
		}
		else{
			echo "<p id='failure'>User was not found.</p>";
		}
	}

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Delete User</title>
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
	<h1>Delete User</h1>
	<table>
		<form method="POST" id="form">
			<tr>
				<td><p>Username</p></td>
				<td><input type="text" name="user" required maxlength="25"></td>
			</tr>
			<tr><td colspan="2" align="center"><input type="submit" name="Submit" value="Delete"></td></tr>
		</table>
	</form>
	<script
	src="https://code.jquery.com/jquery-3.2.1.js"
	integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
	crossorigin="anonymous"></script>
	<script type="text/javascript">
		$( "#form" ).submit(function( event ) {
			var r = confirm("Are you sure?");
			if (r == true) {

			}
			else{
				event.preventDefault();
			}
		});
	</script>
</body>
</html>
