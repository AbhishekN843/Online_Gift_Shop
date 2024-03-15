<?php 
if(!isset($_SESSION)){ session_start(); }
ob_start();
if(!isset($_SESSION['loginid']))
{
	header("Location: shopownerlogin.php");
}
include("header.php");
include("sidebar.php");
include("databaseconnection.php");
?>
        <div id="content" class="float_r">
        	<h1>SHOP OWNER  PANEL</h1>
        
        <div class="cleaner"></div>
        <blockquote> Number of products uploaded : 
                <?php
		$sql= "SELECT * FROM products where shop_id='$_SESSION[shop_id]'";
		$qproducts = mysqli_query($con,$sql);
		echo mysqli_num_rows($qproducts);
		?>
        </blockquote>
                <div class="cleaner"></div>
        <blockquote> Products purchased : 
                <?php
		$sql= "SELECT     COUNT(purchase.qty) AS Expr1, products.shop_id
FROM         products INNER JOIN
                      purchase ON products.prod_id = purchase.prod_id
GROUP BY products.shop_id
HAVING      (products.shop_id = '$_SESSION[shop_id]')";
		$qpurchase = mysqli_query($con,$sql);
		$rsprocount = mysqli_fetch_array($qpurchase);
		echo $rsprocount[0];
		?>
        </blockquote><br />

 <h2>Recent orders:</h2>
           <div style='overflow:auto; width:675px;height:370px;'>
<table width="958" border="1">
  <tr>
    <th width="138" scope="col">Bill ID</th>
    <th width="138" scope="col">Purchase date</th>
    <th width="173" scope="col">Product Name</th>
    <th width="162" scope="col">Size</th>
    <th width="177" scope="col">Customer Name</th>
    <th width="177" scope="col">Quantity</th>
     <th width="177" scope="col">Price</th>
      <th width="177" scope="col">Purchase Status</th>
    </tr>
<?php
$pursql="SELECT  products.*, purchase.*, billing.* FROM billing INNER JOIN purchase ON billing.bill_id = purchase.bill_id LEFT OUTER JOIN products ON purchase.prod_id = products.prod_id WHERE (products.shop_id = '$_SESSION[shop_id]') AND purchase.purchasestatus='PAID'";
$pursql= $pursql . "  ORDER BY purchase.purch_id";
	$purres=mysqli_query($con,$pursql);
	while($prs=mysqli_fetch_array($purres))
	{		
		$rss2="select * from type where size_id='$prs[size_id]'";
		$resrs2=mysqli_query($con,$rss2);
		$rs2=mysqli_fetch_array($resrs2);
		
		$rss3="select * from `customer` where custid='$prs[cust_id]'";
		$resrs3=mysqli_query($con,$rss3);
		$rs3=mysqli_fetch_array($resrs3);
		
  echo"<tr>
    <td>$prs[bill_id]</td>
	<td>$prs[purch_date]</td>
    <td>$prs[prodname]</td>
    <td>$rs2[size]</td>
    <td>$rs3[custfname]</td>
	<td>$prs[qty]</td>
	<td>$prs[price]</td>
	<td>$prs[purchasestatus]";
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