<?php
error_reporting(E_ALL & ~E_NOTICE);
?>
<select name="state" id="state" >
<?php
include("databaseconnection.php");
$sqlAllCountries = "SELECT * FROM location WHERE location_type ='1' AND parent_id='$_GET[country]' ";
$sqlAllCountriesResult = mysqli_query($con,$sqlAllCountries);
while($rssql = mysqli_fetch_array($sqlAllCountriesResult))
{
	echo "<option value='$rssql[location_id]'>$rssql[name]</option>";
}
?>
</select>