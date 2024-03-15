<?php
include("header.php");
include("sidebar.php");
include("databaseconnection.php");

if(isset($_GET['delid']))
{
	$sql="delete from category where cat_id='$_GET[delid]'";
	if(!mysqli_query($con,$sql))
	{
	echo mysqli_error($con);
	}
	else
	{
		echo "<script>alert('Category record deleted successfully..');</script>";
	
	}
}
	
	
?>

    
        <div id="content" class="float_r">
        	<h2>View Category </h2>
            <h5><strong></strong></h5>
            <div class="content_half float_l checkout">
            <form action="" method="post">
            
              <table width="634" border="1">
                <tr>
                  <th scope="col">Category Name</th>
                  <th scope="col">Description</th>
                  <th scope="col">Action</th>
                  
                </tr>
                <?php
				$sql = "SELECT * FROM  `category` ";
				$rsquery = mysqli_query($con,$sql);
				while($rs = mysqli_fetch_array($rsquery))
				{
                echo "<tr>
                  <td>&nbsp;$rs[cat_name]</td>
                  <td>&nbsp;$rs[cat_des]</td>
                  <td>&nbsp;<a  href='maincategory.php?editid=$rs[cat_id]'>Edit </a>| 
				  <a onclick='return yesno()' href='viewcategory.php?delid=$rs[cat_id]'>Delete</a></td>
                </tr>";
				}
				?>
              </table>
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