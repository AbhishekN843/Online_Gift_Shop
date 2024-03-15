<?php
include("header.php");
include("sidebar.php");
include("databaseconnection.php");
if(isset($_POST['submit']))
{
	$catname = mysqli_real_escape_string($con,$_POST['catname']);
	$catdescription = mysqli_real_escape_string($con,$_POST['description']);	

	if(isset($_GET['editid']))
	{
		mysqli_query($con,"UPDATE subcategory SET subcategory='$catname',description='$catdescription', cat_id='$_POST[maincat]' where subcat_id='$_GET[editid]'");
		echo "<script>alert('record updated successfully..');</script>";
		echo"<script>window.location='viewsubcategory.php';</script>";
	}
	else
	{
		$inssql=mysqli_query($con,"INSERT INTO subcategory(subcategory, description, cat_id) VALUES('$catname','$catdescription','$_POST[maincat]')");
		if(mysqli_affected_rows($con) == 1)
		{
		echo "<script>alert('Sub category record inserted successfully..');</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
}

if(isset($_GET['editid']))
{
	$sql = "SELECT * FROM subcategory WHERE subcat_id='$_GET[editid]'";
	$qsql = mysqli_query($con,$sql);
	$rssql = mysqli_fetch_array($qsql);
}
?>
    
        <div id="content" class="float_r">
        	<h2> Sub Category          </h2>
       	  <div class="content_half float_l checkout">
			 <form method="post" action="" name="subcategory" onsubmit="return validatesubcategory()">
            
			    <table width="531" height="176" border="1">
			      <tr>
			        <th height="26" scope="row">Main Category</th>
			        <td><label for="maincat"></label>
			          <select name="maincat" id="maincat">
                      <option value="">Select</option>
                      <?php
					  $sqlcat = "SELECT * FROM category";
					  $resultcat = mysqli_query($con,$sqlcat);
					  while($rscat = mysqli_fetch_array($resultcat))
					  {
						  if($rscat['cat_id']==$rssql['cat_id'])
						  {
						  echo "<option value='$rscat[cat_id]' selected>$rscat[cat_name]</option>";
						  }
						  else
						  {
							   echo "<option value='$rscat[cat_id]'>$rscat[cat_name]</option>";
						  }
					  
					  }
					  
					  ?>                      
	                </select></td>
		          </tr>
			      <tr>
			        <th width="170" height="26" scope="row">Sub Category </th>
                    
			        <td width="305"><input type="text" name="catname" id="catname" value="<?php echo $rssql['subcategory']; ?>" /></td>
		          </tr>
			      <tr>
			        <th scope="row">Description</th>
			        <td>
		            <textarea name="description" id="description" cols="45" rows="5"><?php echo $rssql['description']; ?></textarea></td>
		          </tr>
			      <tr>
			        <th colspan="2" scope="row"><input type="submit" name="submit" id="submit" value="Submit" /></th>
		          </tr>
	        </table>
            </form>
          </div>
            
          <div class="content_half float_r checkout"><br />
          </div>
            
          <div class="cleaner h50"></div>
        </div> 
        <div class="cleaner"></div>
    </div> <!-- END of templatemo_main -->
  <?php
  include("footer.php");
  ?>
  <script type="application/javascript">
	function  validatesubcategory()
	{
		if(document.subcategory.maincat.value == "")
		{
			alert("Category name should not be empty..");
			document.subcategory.maincat.focus();
			return false;
		}
		else if(document.subcategory.catname.value == "")
		{
			alert("Subcategory name should not be empty..");
			document.subcategory.catname.focus();
			return false;
		}
		else if(document.subcategory.description.value == "")
		{
			alert("Description should not be empty..");
			document.subcategory.description.focus();
			return false;
		}
		else
		{
			return true;
		}
	}
  </script>