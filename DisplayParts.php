<?php
	include 'nav.php';
// Start the session
session_start();

?>
	
	

<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript">

function setCookie(cname,cvalue) {
    document.cookie = cname + "=" + cvalue ;
	var str1 = "Page ";
	var res = str1.concat(cValue);
	document.write(res);
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var user=getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
       user = prompt("Please enter your name:","");
       if (user != "" && user != null) {
           setCookie("username", user, 30);
       }
    }
}

</script>
		
		<style>
		body{
	background-color: grey;
	
		}
		td {
  padding-left: 11px;
 
}
table, th, td {
    border: 2px solid black;
	table-layout:fixed;
	width: 90%;
	
}
.button {
    background-color: black; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
}

.button1 {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
}

.button2:hover {
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
}
	</style>
	

	
	</head>
	
<body>
<form method="post">
    <p>Category</p>
    <select name="category">
        <option value=""></option>
        <?php
         $host='earth.cs.utep.edu';
         $user='jrosas5';
         $password='Spartanbot';
         $database='f17cs4339team14';

        $conn = new mysqli($host,$user,$password,$database);
        if($conn->connect_error){
            die("Connection failed: ".$conn->connect_error);
        }

        $query = "SELECT DISTINCT Category FROM allparts;";
        $result = $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_row($result)){
            if ($row[0] != null)
                echo "<option value='$row[0]'>".$row[0]."</option>";
        }
        ?>

    </select>
	<p>Price</p>
	<select name="price">
	<option value=""></option>	
	<?php
        $i=0;
        $j=200;
        while($i < 4000){
			$k =$i+$j;
            echo "<option value='$i'>".$i.'$ - '.$k.'$'."</option>";
            $i = $i+$j;
        }
	?>
	</select>
	
	<p>Sort</p>
	<select name="sort">
		<option value="ASC"> Ascending </option>
		<option value="DESC"> Descending </option>
	</select>
	
    <input type="submit">
</form>
<pre>
<?php

class DisplayParts{

	public $host='earth.cs.utep.edu';
	public $user='jrosas5';
	public $password='Spartanbot';
	public $database='f17cs4339team14';
	public $pageValue="";
		/*
			Establish a connection and run any functions I want. Just uncomment any of the functions
			and the function will run.
		*/
			function mainFunction(){
			
				$conn = new mysqli($this->host,$this->user,$this->password,$this->database);
				if($conn->connect_error){
					die("Connection failed: ".$conn->connect_error);
				}
				else{
				//	echo "Connection was successfully";

				}
			//UNCOMMENT ANY
			//$this->dropTable($conn);
				$this->listParts($conn);
			//$this->listUsers($conn);
			//$this->addNewUser($conn,"Javier","Rosas","admin",$this->saltPasswords("nimda339","admin"),$this->ADMIN);
			//$this->addNewUser($conn,"JavierAlonso","Rosas","jrosas5",$this->saltPasswords("nimda339","jrosas5"),$this->REGULARUSER);
			//$this->createTable($conn);
			//echo "<br>".$this->saltPasswords("Sprint47");
			//$this->updateLastSignin("admin",$conn);
			//$this->deleteUser($conn);
				$this->closeConnection($conn);
			}
			function listParts($conn){
			$var = $_GET['page'];
			//echo $var;
			
			
			//It will only run when parts are first run
			if($var==NULL){
			$this->printLinks($pageInInt);

			if ((!isset($_POST['category']) || !$_POST['category']) && (!isset($_POST['price']) || !$_POST['price']) ){
				$sql = "SELECT * FROM allparts";
			}
			
			elseif ((isset($_POST['category']) || $_POST['category']) && (!isset($_POST['price']) || !$_POST['price']) ){
			    $category = $_POST['category'];
			    $category = str_replace('+', ' ', $category);
			    $sql = "SELECT * FROM allparts WHERE Category = '$category'";
            }
            elseif((!isset($_POST['category']) || !$_POST['category']) && (isset($_POST['price']) || $_POST['price']) ){
			    $i = $_POST['price'];
			    $j = $_POST['price'] + 200;
			    $sql = "SELECT * FROM allparts WHERE Price BETWEEN $i AND $j";
            }
            else {
				$category = $_POST['category'];
			    $category = str_replace('+', ' ', $category);
			    $i = $_POST['price'];
			    $j = $_POST['price'] + 200;
			    $sql = "SELECT * FROM allparts WHERE Price BETWEEN $i AND $j AND Category = '$category'";
            }
			
			$sql.= ' ORDER BY Category '.$_POST['sort'] . " LIMIT 0, 100" ; 
			
				if ($result = mysqli_query($conn, $sql)) {

					/* fetch associative array */


					echo "<table   bgcolor='#DCDCDC'>";

					while ($row = mysqli_fetch_array($result)) {
						echo "<tr>";
						echo "<td ><br>Category: ".$row["Category"].
						"<br>Part Name: " .$row["PartName"] ."<br><br>"
						."<img src="."images/".$row["Associated_image_filename1"]."  />".
						"<img src="."images/".$row["Associated_image_filename2"] ."  />"."<br>".
						"<img src="."images/".$row["Associated_image_filename3"] ."  />".
						"<img src="."images/".$row["Associated_image_filename4"] ."  />".
						"<br>Description 1: ".$row["Description01"] .
						"<br>Description 2: ".$row["Description02"] .
						"<br>Description 3: ".$row["Description03"] .
						"<br>Description 4: ".$row["Description04"] .
						"<br>Description 5: ".$row["Description05"] .
						"<br>Description 6: ".$row["Description06"] .
						"<br><br>Notes: ". $row["Notes"] ."<br>".
						"<br><br>Price: ". $row["Price"] .
						"<br>ShippingCost: ". $row["Estimated_Shipping_Cost"] .
						'<br><br><form name="Purchase" action="checkIfUserLogin.php" method="post">'.
						'<input type = "hidden" name = "id" value ='.$row["PartID"].'>' .
						'<input type="submit" class="button button2" name = "Data to send" value="BUY">'.
						 '</form><br>'.
						"</td>";
						echo "</tr>";
					}
					echo "</table>";

			$this->printLinks($pageInInt);
					/* free result set */
					mysqli_free_result($result);
				}
				else {
					echo "Something went wrong";
				}

			}
			//It will only run when user clicks on a page link
			else{
			$pageInInt=(int)$var;
			$result = $pageInInt*100;
			//echo "<br>Result is ".$result;
			$resultString = (string) $result;
			
			$this->printLinks($pageInInt);


                    $sql = "SELECT PartID, PartName, PartNumber, Suppliers, Category, Description01, Description02, Description03, Description04, Description05, Description06, Price, Estimated_Shipping_Cost,  Associated_image_filename1,  Associated_image_filename2,  Associated_image_filename3,  Associated_image_filename4,  Notes, Shipping_Weight FROM allparts LIMIT 0, 100";

                if ($result = mysqli_query($conn, $sql)) {

					/* fetch associative array */

					echo "<table bgcolor='#DCDCDC'>";

					while ($row = mysqli_fetch_array($result)) {
						echo "<tr>";
						echo "<td ><br>Category: ".$row["Category"].
						"<br>Part Name: " .$row["PartName"] ."<br><br>"
						."<img src="."images/".$row["Associated_image_filename1"]."  />".
						"<img src="."images/".$row["Associated_image_filename2"] ."  />"."<br>".
						"<img src="."images/".$row["Associated_image_filename3"] ."  />".
						"<img src="."images/".$row["Associated_image_filename4"] ."  />".
						"<br>Description 1: ".$row["Description01"] .
						"<br>Description 2: ".$row["Description02"] .
						"<br>Description 3: ".$row["Description03"] .
						"<br>Description 4: ".$row["Description04"] .
						"<br>Description 5: ".$row["Description05"] .
						"<br>Description 6: ".$row["Description06"] .
						"<br><br>Notes: ". $row["Notes"] ."<br>".
						"<br><br>Price: ". $row["Price"] .
						"<br>ShippingCost: ". $row["Estimated_Shipping_Cost"] .
						'<br><br><form name="Purchase" action="checkIfUserLogin.php" method="post">'.
						'<input type = "hidden" name = "id" value ='.$row["PartID"].'>' .
						'<input type="submit" class="button button2" name = "Data to send" value="BUY">'.
						 '</form><br>'.
						"</td>";
						echo "</tr>";
					}
					echo "</table>";
					
					$this->printLinks($pageInInt);
					
					/* free result set */
					mysqli_free_result($result);
				}
				else {
					echo "Something went wrong";
				}
			
			}
			}
			function printLinks($pageInInt){
		echo "<br>Current Page: Page ".($pageInInt+1)."<br>";
		if($pageInInt==NULL||$pageInInt<=9){
						
					echo "<a href='DisplayParts.php?page=0'>Page 1</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=1'>Page 2</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=2'>Page 3</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=3'>Page 4</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=4'>Page 5</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=5'>Page 6</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=6'>Page 7</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=7'>Page 8</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=8'>Page 9</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=9'>Page 10 </a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=10'> >> </a>";
					}
					else if($pageInInt>=10){
					echo "<a href='DisplayParts.php?page=9'> << </a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=10'>Page 11</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=11'>Page 12</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=12'>Page 13</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=13'>Page 14</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=14'>Page 15</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=15'>Page 16</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=16'>Page 17</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=17'>Page 18</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=18'>Page 19</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=19'>Page 20 </a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=20'>Page 21</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=21'>Page 22</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=22'>Page 23</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=23'>Page 24</a>";
					echo "  ";
					echo "<a href='DisplayParts.php?page=24'>Page 25</a>";
					}
		}
		
		}
		$dF = new DisplayParts();
		$dF->mainFunction();
		//<a href="https://www.w3schools.com">Visit W3Schools.com!</a>
			
			
 
		?>
		
		</pre>
		
		

</body>

</html>
