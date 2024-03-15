<?php
if(!isset($_SESSION)){ session_start(); }
include("databaseconnection.php");
?>
    <div id="templatemo_main">
    	<div id="sidebar" class="float_l">
<?php
if($_SESSION['logintype'] =="Administrator")
{
?>	
    	<div class="sidebar_box"><span class="bottom"></span>
            	<h3>Admin Menu</h3>   
                <div class="content"> 
                	<ul class="sidebar_list">
                    	<li class="first"><a href="dashboard.php">Dashboard</a></li>
                    	<li><a href="administrator.php">Add Administrator</a></li>                        
                        <li><a href="viewadministrator.php">View Administrator</a></li>
                        <li><a href="maincategory.php">Add Category</a></li>
                        <li><a href="viewcategory.php">View category</a></li>
                        <li><a href="subcategory.php">Add Sub Category</a></li>
                        <li><a href="viewsubcategory.php">View Sub Category</a></li>
                        <li><a href="viewcustomer.php">View Customer</a></li>
                        <li><a href="product.php">Add Product</a></li>
                        <li><a href="viewproducts.php">View Products</a></li>
                        <li><a href="shopowner.php">Add Shop Owner</a></li>
                        <li><a href="viewshopowner.php">View Shop Owners</a></li>
                        <li><a href="purchasereport.php">View purchase report</a></li>
                        <li><a href="billingreport.php">View billing report</a></li>
                        <li class="last"><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>            
<?php
}
if($_SESSION['logintype'] =="Customer")
{
?>	
    	<div class="sidebar_box"><span class="bottom"></span>
            	<h3>Customer Menu</h3>   
                <div class="content"> 
                	<ul class="sidebar_list">
                    	<li class="first"><a href="customerpanel.php">Home</a></li>
                    	<li><a href="customerpurchasereport.php">Purchase report</a></li>                        
                        <li><a href="customerbillingreport.php">Billing report</a></li>
                        <li><a href="changecustomerprofile.php">Customer Profile</a></li>
                        <li><a href="changepassword.php">Change Password</a></li>
                        <li><a href="addshippingdetails.php">Shipping Details</a></li>
                        <li><a href="viewshippingdetails.php">View Shipping Details</a></li>
                        <li class="last"><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>            
<?php
}
if($_SESSION['logintype'] =="ShopOwner")
{
?>	
    	<div class="sidebar_box"><span class="bottom"></span>
            	<h3>Shop Owner Menu</h3>   
                <div class="content"> 
                	<ul class="sidebar_list">
                    	<li class="first"><a href="shopownerpanel.php">Home</a></li>
                        <li><a href="product.php">Add product</a></li>
                        
                        <li><a href="viewproducts.php">View products</a></li>       
                         <li><a href="changeshopownerpassword.php">Change Password</a></li>
                         <li><a href="changeshopownerprofile.php">Shopowner Profile</a></li>                     
                    	<li><a href="purchasereport.php">Purchase report</a></li>                       
                        <li class="last"><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>            
<?php
}
?>            <div class="sidebar_box"><span class="bottom"></span>
            	<h3>SELLERS</h3>   
                <div class="content"> 
                <?php
					$sql = "SELECT * FROM  shopowner";
					$rsquerycomp = mysqli_query($con,$sql);
					while($rscomp = mysqli_fetch_array($rsquerycomp))
					{
					?>
                       <div class="bs_box">
                       <a href="productslist.php?compid=<?php echo $rscomp['shop_id'] ; ?>"><img src="shopimage/<?php echo $rscomp['imgpath']; ?>" width="58" height="58" /></a>
                       <h4><a href="productslist.php?compid=<?php echo $rscomp['shop_id'] ; ?>"><?php echo $rscomp['compname']; ?></a></h4>
                            <p ><?php echo $rscomp['address']; ?></p>
                            <div class="cleaner"></div>
                        </div>
					<?php
					}
					?>                                        
              </div>
            </div>
        </div>
        