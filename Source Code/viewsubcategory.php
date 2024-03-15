<?php
include("header.php");
include("sidebar.php");
include("databaseconnection.php");


if(isset($_GET['delid']))
{
	$sql="delete from subcategory where subcat_id='$_GET[delid]'";
	if(!mysqli_query($con,$sql))
	{
	echo mysqli_error($con);
	}
	else
	{
		echo "<script>alert('Sub Category record deleted successfully..');</script>";
	
	}
}
	

?>

    
        <div id="content" class="float_r">
        	<h2>View Subcategory</h2>
            <h5><strong></strong></h5>
            <div class="content_half float_l checkout">
            <form action="" method="post">
            
              <table width="634" border="1">
                <tr>
                  <th scope="col">Main Category</th>
                  <th scope="col">Sub Category</th>
                  <th scope="col">Description</th>

                  <th scope="col">Action</th>
                </tr>
                <?php
				$sql = "SELECT * FROM  `subcategory` ";
				$rsquery = mysqli_query($con,$sql);
				while($rs = mysqli_fetch_array($rsquery))
				{
					$sql1 = "SELECT * FROM  category WHERE cat_id='$rs[cat_id]' ";
					$rsquery1 = mysqli_query($con,$sql1);
					$rs1 = mysqli_fetch_array($rsquery1);
                echo "<tr>
                  <td>&nbsp;$rs1[cat_name]</td>
                  <td>&nbsp;$rs[subcategory]</td>
                  <td>&nbsp;$rs[description]</td>
                  <td>&nbsp;<a href='subcategory.php?editid=$rs[subcat_id]'>Edit</a> | 
				  <a onclick='return yesno()' href='viewsubcategory.php?delid=$rs[subcat_id]'>Delete</a></td>
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