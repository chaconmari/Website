<?php
		include 'nav.php';

    $host='earth.cs.utep.edu';
  	$user='jrosas5';
  	$password='Spartanbot';
  	$database='f17cs4339team14';

    $conn = new mysqli($host,$user,$password,$database);
    if($conn->connect_error){
      die("Connection failed: ".$conn->connect_error);
    }
    else{
      //echo "Connection was successfully";
    }

		$var = $_GET['partid'];
   	if ($var != NULL) {
     	$id = $var;
			$username = $_SESSION['username'];

    	$query = "SELECT * FROM allparts WHERE PartID = '$id'";
			$query2 = "SELECT * FROM users WHERE Username = '$username'";

			$result = mysqli_query($conn, $query);
			$result2 = mysqli_query($conn, $query2);
      if ($result && $result2) {

        $row = mysqli_fetch_assoc($result);
				$row2 = mysqli_fetch_assoc($result2);

				$zipcode = $row2['Zip_Code'];
				$weight = $row['Shipping_Weight'];
				$state = $row2['State'];

				$zipcode = substr($zipcode, 0, 3);

				$query3 = "SELECT ZoneGround FROM ziptozone WHERE (HighZip = 0 AND LowZip = '$zipcode') OR (LowZip <= '$zipcode' AND HighZip >= '$zipcode')";
				$query4 = "SELECT * FROM weightzoneprice WHERE Weight = '$weight'";

				$result3 = mysqli_query($conn, $query3);
				$result4 = mysqli_query($conn, $query4);
				if($result3 && $result4) {

					$row3 = mysqli_fetch_assoc($result3);
					$row4 = mysqli_fetch_assoc($result4);

					$zone = "Zone". $row3['ZoneGround'];
					$shipping = $row4[$zone];

	        echo "Price: $row[Price]<br>";
	        echo "Shipping: $shipping<br>";
					if($state == "TX"){
						$tax = $row[Price] * .0825;
						$tax = round($tax, 2);
	        	echo "Tax: $tax<br>";
					}
					$total = $row['Price'] + $shipping + $tax;
	        echo "Total: $total<br>";

					if($state == "TX"){
	?>
		        <html>
		        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
		        <input type="hidden" name="cmd" value="_xclick">
		        <input type="hidden" name="business" value="8CTCRHUTBH7ZE">
		        <input type="hidden" name="lc" value="US">
		        <input type="hidden" name="item_name" value= "<?php echo "$row[PartName]"?>">
		        <input type="hidden" name="item_number" value="<?php echo "$row[PartNumber]"?>">
		        <input type="hidden" name="amount" value="<?php echo "$row[Price]"?>">
		        <input type="hidden" name="currency_code" value="USD">
		        <input type="hidden" name="button_subtype" value="services">
		        <input type="hidden" name="no_note" value="0">
		        <input type="hidden" name="cn" value="Add special instructions to the seller:">
		        <input type="hidden" name="no_shipping" value="2">
		        <input type="hidden" name="tax_rate" value="8.25">
		        <input type="hidden" name="shipping" value="<?php echo "$shipping"?>">
		        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
		        <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		        <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		        </form></html>
<?php
					}
					else{
?>
						<html>
		        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
		        <input type="hidden" name="cmd" value="_xclick">
		        <input type="hidden" name="business" value="8CTCRHUTBH7ZE">
		        <input type="hidden" name="lc" value="US">
		        <input type="hidden" name="item_name" value= "<?php echo "$row[PartName]"?>">
		        <input type="hidden" name="item_number" value="<?php echo "$row[PartNumber]"?>">
		        <input type="hidden" name="amount" value="<?php echo "$row[Price]"?>">
		        <input type="hidden" name="currency_code" value="USD">
		        <input type="hidden" name="button_subtype" value="services">
		        <input type="hidden" name="no_note" value="0">
		        <input type="hidden" name="cn" value="Add special instructions to the seller:">
		        <input type="hidden" name="no_shipping" value="2">
		        <input type="hidden" name="tax_rate" value="0.0">
		        <input type="hidden" name="shipping" value="<?php echo "$shipping"?>">
		        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
		        <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		        <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		        </form></html>
<?php
					}
				}
        /* free result set */
        mysqli_free_result($result);
      }
      else {
        echo "Something went wrong";
      }
    }

?>
