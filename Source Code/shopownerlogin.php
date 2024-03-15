<?php
if(!isset($_SESSION)){ session_start(); }
ob_start();
if(isset($_SESSION['shop_id']))
{
	header("Location:shopownerpanel.php");
}
include("header.php");
include("sidebar.php");
include("databaseconnection.php");
if(isset($_POST['btnlogin']))
{
	$sql="select * from shopowner where login_id='$_POST[emailid]' AND s_password='$_POST[password]'";
	$shplogin=mysqli_query($con,$sql);
	if(mysqli_num_rows($shplogin) == 1)
	{
		$rsrec = mysqli_fetch_array($shplogin);
		$_SESSION['shop_id'] = $rsrec['shop_id'];
		$_SESSION['loginid']=$_POST['emailid'];
		$_SESSION['logintype'] = "ShopOwner";			
		header("Location:shopownerpanel.php");
	}
	else
	{
		echo "<script>alert('Invalid password.....');</script>";
	}
}
?>
        <div id="content" class="float_r">
        	<h2>Welcome to Shop owner Login Panel</h2>
            <h5><strong>Kindly enter login id and password</strong></h5>
            <div class="content_half float_l checkout">
             <form method="post" action="" name="frmshoplogin" onsubmit='return validateshopownerloginpanel()'>
            				Email ID
                  <input name="emailid" type="text" id="emailid"  style="width:300px;"  />
                <br />
                <br />
              Password:
				<input name="password" type="password" id="password"  style="width:300px;"  />
                <br />
                <br />
              <input type="submit" name="btnlogin" id="btnlogin" value="Submit" />
              </form>
            </div>
            
            <div class="content_half float_r checkout"></div>
            
            
            <div class="cleaner h50"></div>
        <h4><a href="forgotpassword.php">Forgot password            </a></h4>
        </div> 
       
        <div class="cleaner"></div>
    </div> <!-- END of templatemo_main -->
<?php
include("footer.php");
?>
<script type="application/javascript">
	function  validateshopownerloginpanel()
	{
		if(document.frmshoplogin.emailid.value == "")
		{
			alert("Enter correct Email Id");
			document.frmshoplogin.emailid.focus();
			return false;
		}
		else if(document.frmshoplogin.password.value == "")
		{
			alert("Enter password..");
			document.frmshoplogin.password.focus();
			return false;
		}
		else
		{
			return true;
		}
	}
</script>