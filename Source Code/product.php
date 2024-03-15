<?php
if(!isset($_SESSION)){ session_start(); }
include("header.php");
include("sidebar.php");
include("databaseconnection.php");
$dt= date("Y-m-d");
if(isset($_POST['submit']))
{
	$prodspecification = mysqli_real_escape_string($con,$_POST['pspecification']);
	$productname = mysqli_real_escape_string($con,$_POST['productname']);
	$prodspecification = mysqli_real_escape_string($con,$_POST['editor1']);
		if(isset($_GET['editid']))
		{
			$filename = rand().$_FILES['browse']['name'];
			move_uploaded_file($_FILES['browse']['tmp_name'],"productimage/".$filename);
				
			$sql="UPDATE products SET prodname='$productname', cat_id='$_POST[category]',subcat_id='$_POST[subcat]',shop_id='$_POST[supplier]',totqty='$_POST[quantity]',price='$_POST[price]',discount='$_POST[discount]',p_warranty='$_POST[warranty]',stockstatus='$_POST[stockstatus]',deliveredin='$_POST[delivery]',prod_specif='$prodspecification'";
			if($_FILES['browse']['name'] != "")
			{
			$sql = $sql . ",images='$filename'";
			}
			$sql = $sql . ",status='$_POST[status]' WHERE prod_id='$_GET[editid]'";
			mysqli_query($con,$sql);
			echo "<script>alert('Record updated successfully....')</script>";
			echo"<script>window.location='viewproducts.php';</script>";
		}
		else
		{
		$filename = rand().$_FILES['browse']['name'];
		move_uploaded_file($_FILES['browse']['tmp_name'],"productimage/".$filename);		
		$sql = "insert into products(cat_id,subcat_id,shop_id,totqty,prodname,price,discount,p_warranty,stockstatus,deliveredin,prod_specif,images,status)values('$_POST[category]','$_POST[subcat]','$_POST[supplier]','$_POST[quantity]','$productname','$_POST[price]','$_POST[discount]','$_POST[warranty]','$_POST[stockstatus]','$_POST[delivery]','$prodspecification','$filename','$_POST[status]')";	
			if(!mysqli_query($con,$sql))
			{
				echo mysqli_error($con);
			}
			else
			{
				echo "<script>alert('New product record inserted successfully..');</script>";
				echo "<script>window.location='product.php';</script>";
			}
		}
}
if(isset($_GET['editid']))
{
$sql="select * from products WHERE prod_id='$_GET[editid]'";
$qsql=mysqli_query($con,$sql);
$resview=mysqli_fetch_array($qsql);	
}
?>
        <div id="content" class="float_r">
<?php
	$ccustomer="SELECT * FROM customer WHERE custid='$_SESSION[cid]'";
	 $qcustomer=mysqli_query($con,$ccustomer);
	 $rscustomer = mysqli_fetch_array($qcustomer);
	 
	 $sbilling="SELECT * FROM billing WHERE bill_id='$_GET[billid]'";
	 $qsbilling=mysqli_query($con,$sbilling);
	 $rsbilling = mysqli_fetch_array($qsbilling);
?>
       	<h1>Products</h1>
<div id="txtcart">
<div id="billingreport">
            <form action="" method="post" enctype="multipart/form-data"  name="frmproduct" onsubmit="return validateproduct()">
              <p>Product Name :<br />
       			<input name="productname" type="text" id="productname"  style="width:300px;" value="<?php echo $resview['prodname'];?>" />       
                <br />
                <br />
                Category :<br />
                <select name="category" id="category" style="width:300px;height:30px;"  onchange="changecategory(this.value)">
                <option value="" >Select</option>
                <?php
				$sql1 ="SELECT * FROM  category";
				$res1 = mysqli_query($con,$sql1);
				while($rs1 = mysqli_fetch_array($res1))
				{
					if($rs1['cat_id']==$resview['cat_id'])
					{
						echo "<option value='" . $rs1['cat_id'] ."' selected>$rs1[cat_name]</value>";
					}
					else
					{
					echo "<option value='$rs1[cat_id]'>" . $rs1['cat_name'] . "</value>";
					}
				}
				?>
                </select>
              </p>
              <p  id="changesubcategory">Sub Category :<br />
                <select name="subcat" id="subcat" style="width:300px;height:30px;"">
                <option value="">Select</option>
                <?php
				$sql2 ="SELECT * FROM  subcategory";
				$res2 = mysqli_query($con,$sql2);
				while($rs2 = mysqli_fetch_array($res2))
				{
					if($rs2['subcat_id']==$resview['subcat_id'])
					{
						echo "<option value='$rs2[subcat_id]' selected>$rs2[subcategory]</value>";
					}
					else
					{
						echo "<option value='$rs2[subcat_id]'>$rs2[subcategory]</value>";
					}
				}
				?>
                </select>
              </p>
              
              <?php
			  if(isset($_SESSION['shop_id']))
			  {
			  ?>
              <input type="hidden" name="supplier" value="<?php echo $_SESSION['shop_id']; ?>" style="width:300px;height:30px;"/>
              <?php
			  }
			  else
			  {
			  ?>
              <p>Shop owner :<br />
                <select name="supplier" id="supplier" style="width:300px;height:30px;">
                <option value="">Select</option>
                <?php
				$sql3="SELECT * FROM  shopowner ";
				$res3 = mysqli_query($con,$sql3);
				while($rs3 = mysqli_fetch_array($res3))
				{
					if($rs3['shop_id']==$resview['shop_id'])
					{
						echo "<option value='$rs3[shop_id]'selected>$rs3[compname]</value>";
					}
					else
					{
						echo "<option value='$rs3[shop_id]'>$rs3[compname]</value>";
					}
				}
				?>
                </select>
              <?php
			  }
			  ?>
              </p>
              <p>Quantity :</p>
              <p>
              <input type="number" name="quantity" onkeydown='return isNumeric(event.keyCode);' value="<?php echo $resview['totqty'];?>" style="width:300px;height:30px;" /><br />
                <br />
                Price :<br />

                <input name="price" type="text" id="price"  style="width:300px;" value="<?php echo $resview['price'];?>"  />
              </p>
              Discount : <br />
<input type="text" name="discount" style="width:300px;"  id="discount" value="<?php echo $resview['discount'];?>" onkeydown='return isNumeric(event.keyCode);'/><br /><br />

              <p>Warranty :<br />
                <input type="text" name="warranty" id="warranty"style="width:300px;" value="<?php echo $resview['p_warranty'];?>"/>
              </p>
              <p>Stock Status :<br />
                <select name="stockstatus" id="stockstatus" style="width:300px;height:30px;">
                <option value="">Select</option>
				<?php
				$arr = array("Available","Out of Stock");
				foreach($arr as $val)
				{
					if($val == $resview['stockstatus'])
					{
					echo "<option value='$val' selected>$val</option>";
					}
					else
					{
					echo "<option value='$val'>$val</option>";
					}
				}
				?>
                </select>
              </p>
              <p>Delivered in (No. of days) :<br />
                <input type="text" name="delivery" id="delivery" value="<?php echo $resview['deliveredin'];?>"style="width:300px;height:30px;"/>
              </p>
              <p>Product Specification :<br />
<?php
include("ckeditor.php");
?>
              </p>
              <p>Image :               &nbsp;&nbsp;&nbsp;&nbsp;<br /> 
                <input type="file" name="browse" id="browse" style="width:300px;height:30px;"  value="" />
                &nbsp;
              </p>
              <p>Status :<br />
            <select name="status" id="status" style="width:300px;height:30px;">
              <?php
			  $arr1=array("Select","Active","Inactive");
			  foreach($arr1 as $val)
			  {
				  if($val==$resview['status'])
		          {
					  
					  echo "<option value='$val' selected>$val</option>";		  
				  }
			  else
			  {
				    echo "<option value='$val'>$val</option>";		  
				  }
			  }
			  ?>
                </select>
              </p>
              <p>
                <input type="submit" name="submit" id="submit" value="Submit" />
              </p>
			  <p>&nbsp;</p>
              </form>
            </div>
   </div>     	
            <div id="txtcart">
 <h1>
</h1>
</form>                    
            </div>            
                    <div style="float:right; width: 215px; margin-top: 20px;"></div>
</div>
        <div class="cleaner"></div>
    </div> <!-- END of templatemo_main -->
<?php
  include("footer.php");
?>
<script type="application/javascript">
function validateproduct()
{
	if(document.frmproduct.productname.value == "")
	{
		alert("Product Name should not blank");
		document.frmproduct.productname.focus();
		return false;
	}
	else if(document.frmproduct.category.value == "")
	{
		alert("Please select Category.");
		document.frmproduct.category.focus();
		return false;
	}
	else if(document.frmproduct.subcat.value == "")
	{
		alert("Please select  Sub Category.");
		document.frmproduct.subcat.focus();
		return false;
	}
	else if(document.frmproduct.supplier.value == "")
	{
		alert("Select Shop owner from the list.");
		document.frmproduct.supplier.focus();
		return false;
	}
	else if(document.frmproduct.quantity.value == "")
	{
		alert("Select number of quantity.");
		document.frmproduct.quantity.focus();
		return false;
	}
	else if(document.frmproduct.price.value == "")
	{
		alert("Price should not be blank.");
		document.frmproduct.price.focus();
		return false;
	}
	else if(document.frmproduct.discount.value == "")
	{
		alert("Enter discount amount..");
		document.frmproduct.discount.focus();
		return false;
	}
	else if(document.frmproduct.warranty.value == "")
	{
		alert("Enter warranty ..");
		document.frmproduct.warranty.focus();
		return false;
	}
	else if(document.frmproduct.stockstatus.value == "")
	{
		alert("Select stock status.");
		document.frmproduct.stockstatus.focus();
		return false;
	}
	else if(document.frmproduct.delivery.value == "")
	{
		alert("Enter delivery days..");
		document.frmproduct.delivery.focus();
		return false;
	}
	else if(document.frmproduct.pspecification.value == "")
	{
		alert("Product specification should not be blank.");
		document.frmproduct.pspecification.focus();
		return false;
	}
	else if(document.frmproduct.browse.value == "")
	{
		alert("Select images for the product.");
		document.frmproduct.browse.focus();
		return false;
	}
	else if(document.frmproduct.status.value == "")
	{
		alert("Select status.");
		document.frmproduct.status.focus();
		return false;
	}
	else
	{
		return true;
	}
}

function changecategory(categoryid) {
    if (categoryid == "") {
        document.getElementById("changesubcategory").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("changesubcategory").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","ajaxchangesubcategory.php?categoryid="+categoryid,true);
        xmlhttp.send();
    }
}
</script>
<script type = "text/javascript">
    function isNumeric(keyCode)
    {
        return ((keyCode >= 48 && keyCode <= 57) || keyCode == 8 || keyCode == 9 || keyCode == 46 || keyCode == 37 || keyCode == 39 ||
                (keyCode >= 96 && keyCode <= 105))
    }
	
    function isAlpha(keyCode)
    {
        return ((keyCode >= 65 && keyCode <= 90) || keyCode == 8 || keyCode == 9 || keyCode == 46 || keyCode == 37 || keyCode == 39 )
    }
	</script>