<?php 
include 'nav.php';

if (!isset($_SESSION['username'])) {
		die("You are not authorized to access this page");
	}

if (isset($_POST['new'])) {


	$host='earth.cs.utep.edu';
	$user='jrosas5';
	$password='Spartanbot';
	$db='f17cs4339team14';

	$conn = mysqli_connect($host,$user,$password,$db);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$username = $_SESSION['username'];
	$new = mysqli_real_escape_string($conn,$_POST['new']);
	$query = "UPDATE users SET Zip_Code ='$new' WHERE Username='$username';";
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	echo "<p id='success'>Zip code updated successfully</p>";
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
	<h1>Chane Zip Code</h1>
	<table>
		<form method="POST">
			<tr>
				<td><p>New Zip Code</p></td>
				<td><input type="text" name="new" required maxlength="11"></td>
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
