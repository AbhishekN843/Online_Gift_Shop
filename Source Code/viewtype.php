<?php
if(!isset($_SESSION)){ session_start(); }
$dt=date("Y-m-d");
include("header.php");
include("sidebar.php");
include("databaseconnection.php");
if(isset($_POST['submit']))
{
	
			$filename = rand().$_FILES['browse']['name'];
	move_uploaded_file($_FILES['browse']['tmp_name'],"productimage/".$filename);
	
	$filename1 = rand().$_FILES[color]['name'];
	move_uploaded_file($_FILES[color]['tmp_name'],"productimage/".$filename1);
	
		if(isset($_GET['editid']))
		{
			
			$qrry="UPDATE type SET prod_id='$_POST[prodid]',size='$_POST[size]'";
			if($_FILES[browse1][name] != "")
			{
			$qrry= $qrry . " ,color='$filename1' "; 	
			}
			if($_FILES['browse']['name'] != "")
			{
			$qrry= $qrry . " ,image='$filename' ";
			}			
			$qrry= $qrry . " where  size_id='$_GET[editid]'";
			
			
			$qry=mysqli_query($con,$qrry);
			echo"<script>alert('Record updated successfully...')</script>";
			echo "<script>window.location='viewtype.php';</script>";		
		}
		else
		{	
	
			$bquery=mysqli_query($con,"insert into type(prod_id,size,color,image)VALUES('$_GET[viewid]','$_POST[size]','$filename1','$filename')");
			if(!$bquery)
			{
			echo mysqli_error($con);
		
			}
			else
			{
				echo "<script>alert('New Product type inserted')</script>";
				echo "<script>window.location='viewtype.php?viewid=$_GET[viewid]';</script>";		
			}
		}
}
if(isset($_GET['editid']))
{
	$quest="SELECT * FROM type WHERE size_id='$_GET[editid]'";
	$sqst=mysqli_query($con,$quest);
	$resl=mysqli_fetch_array($sqst);	
}
if(isset($_GET['delid']))
{
	$ssql="delete from type where size_id='$_GET[delid]'";
	if(!mysqli_query($con,$ssql))
	{
	echo mysqli_error($con);
	}
	else
	{
		echo "<script>alert('type record deleted successfully..');</script>";
		echo "<script>window.location='viewtype.php';</script>";		
	
	}
}
?>

    
        <div id="content" class="float_r">
        	<h2>Add type</h2>
            <h5><strong></strong></h5>
            <div class="content_half float_l checkout">
              <form action="" method="post"  name="type" onsubmit="return validatetype()" enctype="multipart/form-data">
             
              <table width="558" border="1">
  <tr>
    <th scope="row"><div align="left">&nbsp; Size :</div></th>
    <td id="size"><input type="text" name="size" id="size"  value="<?php echo $resl[size];?>"/></td>
  </tr>
  <tr>
    <th scope="row"><div align="left">&nbsp; Color :</div></th>
    <td><input type="file" name="color" id="browse"  /></td>
  </tr>
  <tr>
    <th scope="row"><div align="left">&nbsp; Image : </div></th>
    <td><input type="file" name="browse" id="browse2"  /></td>
  </tr>
  <tr>
    <th colspan="2" scope="row"><input type="submit" name="submit" id="submit" value="Submit" /></th>
    </tr>
</table>

              </form><hr />
            <form action="" method="post">
             	<h2>View type</h2>       
              <table width="634" border="1">
                <tr>
                  <th width="274" scope="col">Product Name</th>
                  <th width="146" scope="col">Size</th>
                  <th width="92" scope="col">Color</th>
                  <th width="92" scope="col">Images</th>
                  <th width="94" scope="col">Action</th>
                </tr>
                <?php
				$vsql = "SELECT * FROM  type ";
				if(isset($_GET[viewid]))
				{
					$vsql = $vsql . " where prod_id='$_GET[viewid]'";
				}
				$vquery = mysqli_query($con,$vsql);
				while($vrs = mysqli_fetch_array($vquery))
				{
					$xsql = "SELECT * FROM  `products` where prod_id=$vrs[prod_id] ";
					$xquery = mysqli_query($con,$xsql);
					$xrs = mysqli_fetch_array($xquery);
                echo "<tr>
                  <td>&nbsp;$xrs[prodname]</td>
                  <td>&nbsp;$vrs[size]</td>
                  <td>&nbsp;<img src='productimage/$vrs[color]' width='50' height='50' ></td>
				 <td>&nbsp;<img src='productimage/$vrs[image]' width='50' height='50' ></td>
                   <td>&nbsp;<a href='viewtype.php?editid=$vrs[size_id]'>Edit |</a>
				  <a  onclick='return yesno()' href='viewtype.php?delid=$vrs[size_id]'> Delete</td></a>
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
 
   
	function   validatetype()
	{
		if(document.type.size.value == "")
		{
			alert("Size should not be empty..");
			document.type.size.focus();
			return false;
		}
		else if(document.type.color.value == "")
		{
			alert("Select a color..");
			document.type.color.focus();
			return false;
		}
       /*  else if(document.type.browse.value == "")
		{
			alert("Select a image..");
			document.type.browse.focus();
			return false;
		}
         */
		else
		{
			return true;
		}
	}
 </script>