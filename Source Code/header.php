<?php
error_reporting(E_ALL & ~E_NOTICE);
if(!isset($_SESSION)){ session_start(); }
include("databaseconnection.php");
if(!isset($_SESSION["cartrefresh"]))
{
	$sql = "DELETE FROM purchase WHERE cust_id='0' AND purchasestatus='Pending'";
	$qsql = mysqli_query($con,$sql);
	
	$_SESSION["cartrefresh"] ="Refresh";
}
//code to update cart details to logged in customer record
if(isset($_SESSION['loginid']))
{
	$sqlupdpurchase = "UPDATE purchase SET cust_id='$_SESSION[cid]' WHERE  cust_id='0' AND purchasestatus='Pending'";
	$qsql = mysqli_query($con,$sqlupdpurchase);
	if(!$qsql)
	{
		echo mysqli_error($qsql);
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Online Gift Shop</title> 
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
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
</head>
<body>
<div id="templatemo_body_wrapper">
<div id="templatemo_wrapper">

	<div id="templatemo_header" style="background-color:#FFF">
	
	
	  <div style="color:#F00;">
			<div>
			<img src="images/onlinegiftshop.jpg" ALIGN="middle">
			<span style="float: right;"> 
	        <?php
			if(isset($_SESSION['loginid']))
			{
				if($_SESSION['logintype'] == "Administrator")
				{
            	echo "<b><a href='logout.php'  style='color:#F00'>Logout</a></b>";
				}
				else if($_SESSION['logintype'] == "ShopOwner")
				{
            	echo "<b> <a href='changeshopownerprofile.php'  style='color:#F00'>My Account</a> <a href='logout.php'  style='color:#F00'>Logout</a></b>";
				}
				else
				{
				echo "<b><a href='changecustomerprofile.php'  style='color:#F00'>My Account</a> | <a href='logout.php'  style='color:#F00'>Logout</a></b>";
				}
			}
			else
			{
				echo "<b><a href='login.php' style='color:#000'>Log In</a></b> | ";			
				echo "<b><a href='registration.php' style='color:#000'>Sign Up</a></b> | ";
			}
			?><br>
            	Shopping Cart: <strong>
				<?php 
				//coding to display number of cart items
				$sqlnocart ="SELECT * FROM purchase WHERE cust_id='" . $_SESSION['cid'] . "' AND purchasestatus='Pending'";
				$qsqlnocart = mysqli_query($con,$sqlnocart);
				$cartcount = mysqli_num_rows($qsqlnocart);
				if($cartcount == 0)
				{
					echo 0;
				}
				if($cartcount == 1)
				{
					echo $cartcount . " item" ;
				}
				else if($cartcount > 1)
				{
					echo $cartcount. " items";
				}
				?> </strong> 
				( <a href="viewcart.php" style='color:#000'>Show Cart</a> )
				</span>
			</div>
		</div>
    </div> <!-- END of templatemo_header -->
    
    <div id="templatemo_menubar">
    	<div id="top_nav" class="ddsmoothmenu">
            <ul>
                <li><a href="index.php" class="selected">Home</a></li>
                <li><a href="productslist.php">Products</a>
                
                <ul>
                <?php
				$hsql="SELECT * from category";
				$hres=mysqli_query($con,$hsql);
				while($hres1=mysqli_fetch_array($hres))
				{
				?>
                <li><a href="productslist.php?catid=<?php echo $hres1['cat_id'];?>" class="selected"> <?php echo $hres1['cat_name'];?></a>
                    <ul>
                    <?php
                    $hsql2="SELECT * from subcategory where cat_id='$hres1[cat_id]' "; 
                    $hres2=mysqli_query($con,$hsql2);
                    while($hrs2=mysqli_fetch_array($hres2))
                    {
                    ?>
                        <li><a href="productslist.php?subcat=<?php echo $hrs2['subcat_id'];?>" class="selected"> <?php echo $hrs2['subcategory'];?></a></li>
                    <?php
                    }
                    ?>
                    </ul>
                </li>
                
             <?php
				}
				?>
            </ul>
              
                </li>
                <li><a href="about.php">About</a></li>
                <li><a href="faqs.php">FAQs</a></li>
                <li><a href="viewcart.php">Cart</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
            <br style="clear: left" />
        </div> <!-- end of ddsmoothmenu -->
        <div id="templatemo_search">
            <form action="productslist.php" method="get">
              <input type="text" value="" name="keyword" id="keyword" title="keyword" onfocus="clearText(this)" onblur="clearText(this)" class="txt_field" />
              <input type="submit" name="Search" value=" " alt="Search" id="searchbutton" title="Search" class="sub_btn"  />
            </form>
        </div>
    </div> <!-- END of templatemo_menubar -->