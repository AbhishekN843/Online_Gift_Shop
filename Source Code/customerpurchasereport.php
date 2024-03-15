<?php 
if(!isset($_SESSION)){ session_start(); }
include("databaseconnection.php");
include("header.php");
include("sidebar.php");
if(isset($_GET['cancelid']))
{
	$sql = "UPDATE purchase SET purchasestatus='Cancelled' WHERE purch_id='$_GET[cancelid]'";
	$qsql = mysqli_query($con,$sql);
	echo "<script>alert('This purchase record cancelled successfully...');</script>";
}
?>
        <div id="content" class="float_r">
        	<h1>Purchase Report</h1>
        <div class="cleaner"></div>    

 <div style='overflow:auto; width:700px;height:370px;'>
<table width="836" border="1">
  <tr>
    <th width="138" scope="col">Bill ID</th>
    <th width="173" scope="col">Product Name</th>
    <th width="162" scope="col">Size</th>
    <th width="177" scope="col">Customer Name</th>
    <th width="177" scope="col">Quantity</th>
    <th width="177" scope="col">Price</th>
    <th width="177" scope="col">Purchase Status</th>
  </tr>
    <?php
	$pursql="SELECT * from purchase where cust_id='$_SESSION[cid]'";
	$purres=mysqli_query($con,$pursql);
	while($prs=mysqli_fetch_array($purres))
	{
		$rss1="select * from products where prod_id='$prs[prod_id]'";
		$resrs1=mysqli_query($con,$rss1);
		$rs1=mysqli_fetch_array($resrs1);
		
		$rss2="select * from type where size_id='$prs[size_id]'";
		$resrs2=mysqli_query($con,$rss2);
		$rs2=mysqli_fetch_array($resrs2);
		
		$rss3="select * from `customer` where custid='$prs[cust_id]'";
		$resrs3=mysqli_query($con,$rss3);
		$rs3=mysqli_fetch_array($resrs3);
		
		echo "<tr>
				<td>$prs[bill_id]</td>
				<td>$rs1[prodname]</td>
				<td>$rs2[size]</td>
				<td>$rs3[custfname]</td>
				<td>$prs[qty]</td>
				<td>$prs[price]</td>
				<td>$prs[purchasestatus]";
				if($prs['purchasestatus'] == 'PAID' || $prs['purchasestatus'] == 'Cash On Delivery' )
				{
					echo "<br /><a href='customerpurchasereport.php?cancelid=$prs[0]' onclick='return confirmcancellation($prs[0])'>Cancel order</a>";
				}
		echo "</td></tr>";
	}
	?>
</table>
</div>
    
</div> 
        <div class="cleaner"></div>
    </div> <!-- END of templatemo_main -->
<?php
include("footer.php");
?>
<script type="application/javascript">
function confirmcancellation(purchaseid)
{
	var r = confirm("Are you sure want to cancel this order??");
	if (r == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>