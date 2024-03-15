<?php
include("header.php");
include("sidebar.php");
include("databaseconnection.php");


if(isset($_GET['delid']))
{
	$sql="delete from shopowner where shop_id='$_GET[delid]'";
	if(!mysqli_query($con,$sql))
	{
	echo mysqli_error($con);
	}
	else
	{
		echo "<script>alert('Shop Owner record deleted successfully..');</script>";
	
	}
}
	


?>

    
        <div id="content" class="float_r">
        	<h2>View Shop Owners</h2>
            <h5><strong></strong></h5>
            <div class="content_half float_l checkout">
            <form action="" method="post">
            
              <table width="634" border="1">
                <tr>
                  <th scope="col">Company  Name</th>
                  <th scope="col">Address</th>
                  <th scope="col">State</th>
                  <th scope="col">Country</th>
                  <th scope="col">Contact No</th>
                  <th scope="col">Login ID</th>
                  <th scope="col">Images</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
                <?php
				$sql = "SELECT * FROM  `shopowner` ";
				$rsquery = mysqli_query($con,$sql);
				while($rs = mysqli_fetch_array($rsquery))
				{
					
					
                echo "<tr>
                  <td>&nbsp;$rs[compname]</td>
                  <td>&nbsp;$rs[address]</td>
                  <td>&nbsp;$rs[state]</td>
                  <td>&nbsp;$rs[country]</td>
				    <td>&nbsp;$rs[contact_no]</td>
					  <td>&nbsp;$rs[login_id]</td>
					    <td>&nbsp;<img src='shopimage/$rs[imgpath]' width='50' height='50'></td>
						 <td>&nbsp;$rs[status]</td>
                  <td>&nbsp;<a href='shopowner.php?editid=$rs[shop_id]'>Edit |</a>
				  <a onclick='return yesno()' href='viewshopowner.php?delid=$rs[shop_id]'> Delete</td></a>
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