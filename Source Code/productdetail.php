<?php
if(!isset($_SESSION)){ session_start(); }
include("header.php");
include("databaseconnection.php");
include("sidebar.php");
$checkcart="SELECT * FROM purchase WHERE prod_id='$_GET[proid]' AND cust_id='$_SESSION[loginid]' AND purchasestatus='Pending'";
$rescart=mysqli_query($con,$checkcart);
$sql="SELECT * FROM products where prod_id='$_GET[proid]'";
$ressql=mysqli_query($con,$sql);
$res=mysqli_fetch_array($ressql);
$sqlshopowner="SELECT * FROM shopowner where shop_id='$res[shop_id]'";
$ressqlshopowner=mysqli_query($con,$sqlshopowner);
$resshopowner=mysqli_fetch_array($ressqlshopowner);
?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "top_nav", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<div id="content" class="float_r">
        	<h1><?php echo ucfirst($res['prodname']); ?></h1>
           
            <div class="content_half float_l">
<form method="get" action="viewcart.php" name="form1" onsubmit="return validatesubmission()">
<input type="hidden" name="productid" value="<?php echo $_GET['proid']; ?>" />
<table width="350" height="301" border="1" class="tftable">
  <tr>
    <td width="231" height="295">&nbsp;
<?php
//Code to display default size
if(!isset($_GET['size_id']))
{
	$fsql5="SELECT * FROM type WHERE prod_id='$_GET[proid]' limit 0,1";
	$fres5=mysqli_query($con,$fsql5);
	if(mysqli_num_rows($fres5) == 1)
	{
		$numfres = mysqli_fetch_array($fres5);
		 $_GET['size_id'] = $numfres['size_id'];
	}
}
else
{
	$fsql5="SELECT * FROM type WHERE prod_id='$_GET[proid]' AND size_id='$_GET[size_id]' limit 0,1";
	$fres5=mysqli_query($con,$fsql5);
	if(mysqli_num_rows($fres5) == 1)
	{
		$numfres = mysqli_fetch_array($fres5);
	}	
}

if(isset($_GET['size_id1']))
{
 	$fsql4="SELECT * FROM type WHERE size_id='$_GET[size_id]'";
	$fres4=mysqli_query($con,$fsql4);
	$frs4=mysqli_fetch_array($fres4);
	$prodimage =  $frs4['image'];
}
else
{
	$prodimage =  $res['images']; 
}
?>    
    <a  rel="lightbox[portfolio]" href="productimage/<?php echo $prodimage; ?>">
<img src="productimage/<?php echo $prodimage; ?>" alt="" width="100%" height="100%" />
			
</a></td>
    <td width="60" align="center" valign="top">&nbsp;&nbsp;<strong>Colour</strong><hr />
    <?php
			  $fsql2="SELECT * FROM type where prod_id='$_GET[proid]' GROUP BY color";
			  $fres2=mysqli_query($con,$fsql2);
			  while($frs2=mysqli_fetch_array($fres2))
			  {
				   	echo "
					<a href='productdetail.php?proid=$_GET[proid]&size_id=$frs2[size_id]&size_id1=size_id1'>
					<img SRC='productimage/$frs2[color]' width='30' height='30' >
					</a>
					<hr />
					";
					echo "<input type='hidden' name='color' value='$frs2[size_id]' checked>";
			  }
			  ?>&nbsp;&nbsp;</td>
    <td width="50" align="center" valign="top">&nbsp;&nbsp;<strong>Size</strong><hr />
			<?php
			  $fsql1="SELECT * FROM type WHERE prod_id='$_GET[proid]' AND color='$numfres[color]'";
			  $fres1=mysqli_query($con,$fsql1);
			  while($fqres1=mysqli_fetch_array($fres1))
			  {
				   	echo "<input type='radio' name='size' value='$fqres1[size_id]' checked>$fqres1[size]<hr />";
			  }
			  ?>
    </tr>
</table>


		    </div>
		
            <div class="content_half float_r">
                <table width="349" >
                 <tr>
                        <td width='160'>Product Name:</td>
                        <td><?php echo $res['prodname']; ?></td>
                  </tr>
					<tr>
                        <td width='160'>Shop owner:</td>
                        <td><?php echo $resshopowner['compname']; ?></td>
                  	</tr>
                    <tr>
                        <td>Warranty:</td>
                        <td><?php echo $res['p_warranty']; ?></td>
                    </tr>
                    <tr>
                    	<td>Stock Status</td>
                        <td><?php echo $res['stockstatus']; ?></td>
                    </tr>
					 <tr>
                        <td>Delivered In:</td>
                        <td><?php echo $res['deliveredin']; ?> days</td>
                    </tr>
					 <tr>
                        <td>Available quantity:</td>
                        <td><?php echo $res['totqty']; ?> only</td>
                        <input type="hidden" name="totqty" value="<?php echo $res['totqty']; ?>" />
                    </tr>
					 <tr>
					   <td height="43" colspan="2">
                       <input type="hidden" name="price" value="<?php echo $res['price']; ?>" />
                       <h3>
					   <?php
							   if($res['discount']==0)
							   {
								echo  "<HR WIDTH='90%' align='LEFT'>MRP : Rs." . $res['price']. "<HR WIDTH='90%' align='LEFT'>";
							   }
							   else
							   {
							   echo  "<HR WIDTH='90%' align='LEFT'>MRP : <strike>Rs." . $res['price']. "</strike><br /><HR WIDTH='90%' align='LEFT'>";
								echo "Discount : ". $res['discount'] . " %<HR WIDTH='90%' align='LEFT'></p>";
								echo "<font color='green'>Selling Price : Rs." ;
								include("functioncalculateprice.php");
								 $price = calculateprice($res['price'],$res['discount']);
								 echo "$price</font>";
								echo " <HR WIDTH='90%' align='LEFT'></p>"; 
							   }
					   
						?>
                        <br />+  (Free delivery)</h3> </tr>
                </table>
                </table>
			
              <div class="cleaner h20"></div>
              <?php
			     if($res['totqty'] == 0)
						{
							echo "<font color='red'><strong>Out of Stock</strong></font>";
						}
						else
						{
			?>
				Quantity : <input type="number" name="qty" style="width:50px;" <?php
			   if(mysqli_num_rows($rescart) >= 1)
			   {
				   echo "disabled";
			   }
			   ?>/>
               <input type="submit" name="submit" value="Add to Cart" 
               <?php
			   if(mysqli_num_rows($rescart) >= 1)
			   {
				   echo "disabled";
			   }
			   ?>
               />
               <?php
			   if(mysqli_num_rows($rescart) >= 1)
			   {
				   echo "<br /><font color='blue'>This product is already added in the cart</font>";
			   }
			   ?>
			<?php
						}
			?>
			</div>
    </form>           
            <div class="cleaner h30"></div>
         
            <h4>Product Description</h4>
<?php 
			echo "<p>".$res['prod_specif']. "</p>";
  ?>          
          <div class="cleaner h50"></div>
            
            <div id="content" class="float_r">
        	<h3>Related Products</h3>
            <?php
			$i=0;
			$sql1 ="SELECT * FROM products where status='Active' AND cat_id='$res[cat_id]' ORDER BY rand() LIMIT 0,3";
			$qsql1 =mysqli_query($con,$sql1);
			while($rsq1 = mysqli_fetch_array($qsql1))
			{
                if($i=="2")
                {
					echo "<div class='product_box  no_margin_right'>";
					echo '<div class="cleaner"></div>';
					$i=0;
                }
				else
				{
					echo "<div class='product_box'>";
					echo '<div class="cleaner"></div>';					
				}
                ?>
            
            	<h3>
                <a href="productdetail.php?proid=<?php echo $rsq1['prod_id']; ?>"><strong><?php echo ucfirst($rsq1['prodname']); ?></strong></a></h3>
            	<a href="productdetail.php?proid=<?php echo $rsq1['prod_id']; ?>"><img src="productimage/<?php echo $rsq1['images']; ?>" alt="<?php echo $rsq1['prodname']; ?>"  width="100%" height="100%" /></a>
              <p class="product_price">Rs. <?php echo $rsq1['price']; ?></p>
                <a href="shoppingcart.php" class="addtocart"></a>
                <a href="productdetail.php?proid=<?php echo $rsq1['prod_id']; ?>" class="detail"></a>
            </div>     
            <?php
			$i++;
			}
			?>  	
        </div> 
        </div> 
        <div class="cleaner"></div>
    </div> <!-- END of templatemo_main -->
 <?php
 include("footer.php");
 ?>
<script type="application/javascript">
function validatesubmission()
{
	if(document.form1.qty.value>document.form1.totqty.value)
	{
		alert("Entered quantitiy is larger than available quantity..");
		return false;
	}
	else if(document.form1.qty.value=="")
	{
		alert("Enter quantity..");
		document.form1.qty.focus();
		return false;
	}
	
	else
	{
		return true;
	}
}
</script>