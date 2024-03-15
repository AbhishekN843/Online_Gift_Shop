<?php
if(!isset($_SESSION)){ session_start(); }
include("databaseconnection.php");
if(isset($_GET['qty']))
{
	$cartselect="UPDATE purchase SET qty='$_GET[qty]' where purch_id='$_GET[purch_id]'";
	if(!mysqli_query($con,$cartselect))
	{
		echo mysqli_error($con);
	}
}
	$grandtotalprice = $totprice = 0;
	$cartselect="SELECT * FROM purchase where cust_id='$_SESSION[cid]' AND purchasestatus='Pending'";
	$res=mysqli_query($con,$cartselect);
	if(mysqli_num_rows($res)  >= 1)
	{
?>
        	<table width="685" cellspacing="0" cellpadding="5" border="1">
                   	  <tr bgcolor="#ddd">
                        	<th width="130" align="left">Image </th> 
                        	<th width="143" align="left">Product Name </th> 
                       	  	<th width="62" align="center">Quantity </th> 
                        	<th width="72" align="right">Price </th>
                        	<th width="59" align="right">Discount</th> 
                        	<th width="80" align="right">Total </th> 
                        	<th width="53"> </th>
                            
                      </tr>
                      <?php
					  while($result=mysqli_fetch_array($res))
					  {
						  $cartselect1="SELECT * FROM products	 where prod_id='$result[prod_id]'";
						  $res1=mysqli_query($con,$cartselect1);
						  $result1=mysqli_fetch_array($res1);
					  ?>
                    	<tr>
                        	<td>
<img src="productimage/<?php 
				//check image
				$fsqltype="SELECT * FROM type WHERE prod_id='$result[prod_id]'";
				$qtype=mysqli_query($con,$fsqltype);
				if(mysqli_num_rows($qtype) >= 1)
				{
				 	$fsql4="SELECT * FROM type WHERE prod_id='$result[prod_id]' limit 0,1";
					$fres4=mysqli_query($con,$fsql4);
					$frs4=mysqli_fetch_array($fres4);
					echo $prodimage =  $frs4['image'];
				}
				else
				{
					echo $prodimage =  $result1['images'];	
				}
				?>" alt="" width="124" height="85" /></td> 
                        	<td><?php echo $result1['prodname']; ?></td> 
                            <td align="center">
<input name="availableqty" id="availableqty" type="text" value="<?php echo $result['qty']; ?>" style="width: 40px; text-align: right" onkeyup="calcval(<?php echo $result['purch_id']; ?>,this.value,<?php echo $result1['totqty']; ?>)" /> </td>
                            <td align="right">Rs.<?php echo $result['price']; ?></td>
                            <td align="right">Rs.<?php echo $discount = (($result['qty']* $result['price'])*$result1['discount'])/100; ?></td> 
                            <td align="right">Rs.<?php  echo $totprice = ($result['qty']* $result['price']) - $discount; ?></td>
                            <td align="center"><a href="viewcart.php?delid=<?php echo $result['purch_id']; ?>"><img src="images/remove_x.gif" alt="remove" width="14" height="18" /><br />Remove</a> </td>
						</tr>
                       <?php
                       $grandtotalprice = $grandtotalprice + $totprice;
					   }
					   
					   ?>
                        <tr>
                        	<td colspan="3" align="right"  height="30px"></td>
                            <td align="right" style="background:#ddd; font-weight:bold"> Total </td>
                            <td colspan="3" align="center" style="background:#ddd; font-weight:bold">Rs. <?php echo $grandtotalprice; ?>  </td>
                        </tr>
					</table>
                    <?php
					if(isset($_SESSION['cid']))
					{
					?>
                    <p style="float:right; width: 215px; margin-top: 20px;"><a href="confirmorders.php"><strong>Proceed to checkout</strong></a></p>
                    <?php
					}
					else
					{
					?>
					 <p style="float:right; width: 215px; margin-top: 20px;"><a href="login.php?cart=checkout"><strong>Proceed to checkout</strong></a></p>
                    <?php
					}
					?>
                    <p style="float:right; width: 215px; margin-top: 20px;"><a href="productslist.php"><strong>Continue shopping</strong></a></p>
                      <?php
				}
				else
				{
				?>
                   <p><h2>No items found in the cart</h2></p>
                <?php
				}
				?>