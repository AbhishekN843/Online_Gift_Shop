<?php
include("header.php");
include("sidebar.php");
include("databaseconnection.php");

if(isset($_GET['delid']))
{
	$sql="delete from customer where custid='$_GET[delid]'";
	if(!mysqli_query($con,$sql))
	{
	echo mysqli_error($con);
	}
	else
	{
		echo "<script>alert('Customer record deleted successfully..');</script>";
	
	}
}
	

?>

    
        <div id="content" class="float_r">
        	<h2>View Customer</h2>
            <h5><strong></strong></h5>
            <div class="content_half float_l checkout">
            <form action="" method="post">
            <div style='overflow:auto; width:700px;height:370px;'>
            
              <table width="634" border="1">
                <tr>
                  <th scope="col">First  Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">DOB</th>
                  <th scope="col">Address</th>
                  <th scope="col">State</th>
                  <th scope="col">Country</th>
                  <th scope="col">Contact No</th>
                  <th scope="col">Pincode</th>
                  <th scope="col">Email ID</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
                <?php
				$sql = "SELECT * FROM  `customer` ";
				$rsquery = mysqli_query($con,$sql);
				while($rs = mysqli_fetch_array($rsquery))
				{
					 $qaddress="SELECT * FROM address where custid='$rs[custid]'";
				  $qadd1=mysqli_query($con,$qaddress);
				 $qadd2=mysqli_fetch_array($qadd1);
				 
                echo "<tr>
                  <td>&nbsp;$rs[custfname]</td>
                  <td>&nbsp;$rs[custlname]</td>
                  <td>&nbsp;$rs[dob]</td>
		            <td>&nbsp;$qadd2[address]</td>
				    <td>&nbsp;$qadd2[state]</td>
					  <td>&nbsp;$qadd2[country]</td>
					    <td>&nbsp;$qadd2[contactno]</td>
						<td>&nbsp;$qadd2[pincode]</td>
				         <td>&nbsp;$rs[email]</td>
						    <td>&nbsp;$rs[status]</td>
                  <td>&nbsp;
				  <a onclick='return yesno()' href='viewcustomer.php?delid=$rs[custid]'>Delete</a></td>
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