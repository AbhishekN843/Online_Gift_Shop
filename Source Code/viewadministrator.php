<?php
include("header.php");
include("sidebar.php");
include("databaseconnection.php");

if(isset($_GET['delid']))
{
	$sql="DELETE FROM administrator WHERE admin_id='$_GET[delid]'";
	if(!mysqli_query($con,$sql))
	{
		echo mysqli_error($con);
	}
	else
	{
		echo "<script>alert('Administrator record deleted successfully..'); </script>";
	}
}

?>

    
        <div id="content" class="float_r">
        	<h2>View Administrator </h2>
            <h5><strong></strong></h5>
            <div class="content_half float_l checkout">
            <form action="" method="post">
            
              <table width="634" border="1">
                <tr>
                  <th scope="col">Admin Name</th>
                  <th scope="col">Login ID</th>
                  <th scope="col">Email ID</th>
                  <th scope="col">Contact No.</th>
                  <th scope="col">Action</th>
                </tr>
                <?php
				$sql = "SELECT * FROM  `administrator` ";
				$rsquery = mysqli_query($con,$sql);
				while($rs = mysqli_fetch_array($rsquery))
				{
                echo "<tr>
                  <td>&nbsp;$rs[name]</td>
                  <td>&nbsp;$rs[login_id]</td>
                  <td>&nbsp;$rs[email_id]</td>
                  <td>&nbsp;$rs[contactno]</td>
                  <td>&nbsp;<a href='administrator.php?editid=$rs[admin_id]'>Edit |</a>
				   <a onclick='return yesno()' href='viewadministrator.php?delid=$rs[admin_id]'>Delete</a>
				   </td>
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