<?php
include("header.php");
include("sidebar.php");
include("databaseconnection.php");
?>
        <div id="content" class="float_r">
        	<h1> Products</h1>
            <?php
			$i=0;
			$sql ="SELECT * FROM products where status='Active'";
			if(isset($_GET['catid']))
			{
			$sql = $sql . " AND cat_id='$_GET[catid]' ";
			}
			if(isset($_GET['subcat']))
			{
			$sql = $sql . " AND subcat_id='$_GET[subcat]' ";
			}
			if(isset($_GET['keyword']))
			{
			$sql = $sql . " AND prodname LIKE '%$_GET[keyword]%' ";				
			}
			if(isset($_GET['compid']))
			{
			$sql = $sql . " AND shop_id='$_GET[compid]' ";								
			}
			
			$qsql =mysqli_query($con,$sql);
			while($rsq = mysqli_fetch_array($qsql))
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
            
            	<h3 ><a href="productdetail.php?proid=<?php echo $rsq['prod_id']; ?>"><strong><?php echo ucfirst($rsq['prodname']); ?></strong></a></h3>
            	<a href="productdetail.php?proid=<?php echo $rsq['prod_id']; ?>"><img src="productimage/<?php 
				//check image
				$fsqltype="SELECT * FROM type WHERE prod_id='$rsq[prod_id]'";
				$qtype=mysqli_query($con,$fsqltype);
				if(mysqli_num_rows($qtype) >= 1)
				{
				 	$fsql4="SELECT * FROM type WHERE prod_id='$rsq[prod_id]' limit 0,1";
					$fres4=mysqli_query($con,$fsql4);
					$frs4=mysqli_fetch_array($fres4);
					echo $prodimage =  $frs4['image'];
				}
				else
				{
					echo $prodimage =  $rsq['images'];	
				}
				?>" alt="<?php echo $rsq['prodname']; ?>"  width="100" height="150" /></a>
               
              <p class="product_price">Rs. <?php echo $rsq['price']; ?></p>
                <?php
				 $checkcart="SELECT * FROM purchase WHERE prod_id='$rsq[prod_id]' AND cust_id='$_SESSION[loginid]' AND purchasestatus='Pending'";
				$rescart=mysqli_query($con,$checkcart);
			if(mysqli_num_rows($rescart) == 1)
			{
				?>
                <a href="viewcart.php" >Exist in Cart</a>
                <?php
			}
			else
			{
				if($rsq['totqty'] == 0)
				{
					echo "<font color='red'><strong>Out of Stock</strong></font>";
				}
				else
				{
				?>
                <a href="viewcart.php?productid=<?php echo $rsq['prod_id']; ?>&price=<?php echo $rsq['price']; ?>&qty=1&submit=Add+to+Cart" class="addtocart"></a>
                <?php
				}
			}
				?>
                <a href="productdetail.php?proid=<?php echo $rsq['prod_id']; ?>" class="detail"></a>
            </div>     
            <?php
			$i++;
			}
			?>  	
        </div> 
        <div class="cleaner"></div>
    </div> <!-- END of templatemo_main -->
  <?php
  include("footer.php");
  ?>