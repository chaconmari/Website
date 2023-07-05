  <?php
	session_start();
	
	?>
<?php 

	if (!isset($_SESSION['username'])) {
		header("Location: http://cs5339.cs.utep.edu/jrosas5/TeamProject/LoginPage.php"); /* Redirect browser */
exit();
		
		 if(isset($_GET['id'])){
		 $id = $_GET['id'];
		 }
		 $_SESSION["part"] = $id;
	}
else {
	 if(!empty($_POST["id"])){
		 $id = $_POST["id"];
		//echo "Working ".$id;
		 }
		
		 $_SESSION["part"] = $id;
		// echo "NOT Working ".$_SESSION["part"];
		 header("Location: purchase.php?partid=" . $id  );
	
exit();
}
	
	?>
