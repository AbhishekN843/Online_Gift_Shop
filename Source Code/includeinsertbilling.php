<?php
		$sql = "INSERT INTO billing(custid,address_id, purch_date, cardtype, cardno, cvvno, expirydate) VALUES ('$_SESSION[cid]','$_POST[address]','$dt','$_POST[cardtype4]','$_POST[cardnumber]','$_POST[cvvno]','$_POST[expmonth]/$_POST[expyear]')";	
		$q = mysqli_query($con,$sql);
		$lastinsid = mysqli_insert_id($con);	
		$cartselect="UPDATE purchase  SET purchasestatus='$paymenttype',bill_id='$lastinsid' where cust_id='$_SESSION[cid]' AND purchasestatus='Pending'";
		if(!mysqli_query($con,$cartselect))
		{
			echo mysqli_error($con);
		}
		
		$sqlpurchase = "SELECT * FROM  purchase where bill_id='$lastinsid'";
		$qsqlpurchase = mysqli_query($con,$sqlpurchase);
		while($rspurchase = mysqli_fetch_array($qsqlpurchase))
		{
			$cartselect="UPDATE products  SET totqty=totqty - $rspurchase[qty] where prod_id='$rspurchase[prod_id]'";
			if(!mysqli_query($con,$cartselect))
			{
				echo mysqli_error($con);
			}
		}
		echo "<script>alert('Order confirmed successfully....')</script>";
		echo"<script>window.location='orderbilling.php?billid=$lastinsid';</script>";
?>