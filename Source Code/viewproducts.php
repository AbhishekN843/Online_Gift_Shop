<?php
if(!isset($_SESSION)){ session_start(); }
include("header.php");
include("sidebar.php");
include("databaseconnection.php");

if(isset($_GET['delid']))
{
	$sql="delete from products where prod_id='$_GET[delid]'";
	if(!mysqli_query($con,$sql))
	{
	echo mysqli_error($con);
	}
	else
	{
		echo "<script>alert('Product record deleted successfully..');</script>";
	
	}
}
?>
        <div id="content" class="float_r">
        	<h2>View Products</h2>
            <h5><strong></strong></h5>
            <div class="content_half float_l checkout">
            <form action="" method="post">
              <div style='overflow:auto; width:700px;height:370px;'>
                <table width="1260" border="1">
                  <tr>
                    <th scope="col">Product  Name</th>
                    <th scope="col">Total sales</th>
                    <th scope="col">Category</th>
                    <th scope="col">Sub Category</th>
                    <th scope="col">Shop Owner</th>
                      <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">discount</th>
                    <th scope="col">Warranty</th>
                    <th scope="col">Stock Status</th>
                    <th scope="col">Deliveredin</th>                   
                    <th scope="col">Image</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                  <?php
				  if($_SESSION['logintype'] == "ShopOwner")
				  {
						$sql = "SELECT * FROM  products WHERE shop_id='$_SESSION[shop_id]'";
				  }
				  else
				  {
						$sql = "SELECT * FROM  products ";
				  }
				$rsquery = mysqli_query($con,$sql);
				while($rs = mysqli_fetch_array($rsquery))
				{
					
					$sql1purchase = "SELECT sum(qty) FROM  purchase WHERE prod_id='$rs[prod_id]'  ";
					$rsquery1purchase = mysqli_query($con,$sql1purchase);
					$rs1purchase = mysqli_fetch_array($rsquery1purchase);
					
					$sql1 = "SELECT * FROM  category WHERE cat_id='$rs[cat_id]'  ";
					$rsquery1 = mysqli_query($con,$sql1);
					$rs1 = mysqli_fetch_array($rsquery1);
					
					$sql2 = "SELECT * FROM  subcategory WHERE subcat_id='$rs[subcat_id]'  ";
					$rsquery2 = mysqli_query($con,$sql2);
					$rs2 = mysqli_fetch_array($rsquery2);

					$sql3 = "SELECT * FROM  shopowner WHERE shop_id='$rs[shop_id]'  ";
					$rsquery3 = mysqli_query($con,$sql3);
					$rs3 = mysqli_fetch_array($rsquery3);
					
					$sql4 = "SELECT * FROM  purchase WHERE prod_id='$rs[prod_id]'  ";
					$rsquery4 = mysqli_query($con,$sql4);
					$rs4 = mysqli_fetch_array($rsquery4);
										
					
                echo "<tr>
				   	<td>&nbsp;$rs[prodname]</td>	
                  <td>&nbsp;$rs1purchase[0]</td>
                  <td>&nbsp;$rs1[cat_name]</td>
                  <td>&nbsp;$rs2[subcategory]</td>
                  <td>&nbsp;$rs3[compname]</td>
				    <td>&nbsp;$rs[totqty]</td>
					  <td>&nbsp;$rs[price]</td>
					<td>&nbsp;$rs[discount]</td>
					  <td>&nbsp;$rs[p_warranty]</td>
					    <td>&nbsp;$rs[stockstatus]</td>
						  <td>&nbsp;$rs[deliveredin]</td>
						   <td>&nbsp;<img src='productimage/$rs[images]' width='50' height='50' ></td>		
						    <td>&nbsp;$rs[status]</td>
                  <td>&nbsp;<a href='product.php?editid=$rs[prod_id]'>
				  Edit  </a><br>
				  &nbsp;&nbsp;<a onclick='return yesno()' href='viewproducts.php?delid=$rs[prod_id]'>Delete</a><br>
				  &nbsp;&nbsp;<a href='viewtype.php?viewid=$rs[prod_id]'>View type</a>
				  </td>
                </tr>";
				}
				?>
                </table>
              </div>
              <p>&nbsp;</p>
            </form>
            </div>
            
            
          <div class="content_half float_r checkout"><br />
                <br />
          </div>
           
            
          <div class="cleaner h50"></div>
            <h3>&nbsp;</h3>
        </div> 
        <div class="cleaner"></div>
    </div> <!-- END of templatemo_main -->
  <?php
  include("footer.php");
  ?>
  <script type="application/javascript">
  function yesno()
  {
	  if(confirm("Are you sure?")==true)
	  {
		  return true;
	  }
	  else
	  {
		  return false;
		  }
  }
  </script>