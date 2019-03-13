<!DOCTYPE html>
<html>
<head>
<title>Log Call</title>
<script>
function validateForm() {
  var x = document.forms["frmlogcall"]["callerName"].value;
  if (x == "") {
    alert("Name must be filled out");
    return false;
  }
}
</script>
<?php include "head.php"; 

	if(isset($_POST['btnProcessCall']))
	{
		$con=mysql_connect("localhost","ameera_pessdb","password123");
		if(!$con)
		{	
			die('Cannot connect to database :'.mysql_error());
		}
		mysql_select_db("12_ameera_pessdb",$con);
	
		$sql= "INSERT INTO incident (callerName,phoneNumber,incidentTypeId,incidentLocation,incidentDesc,incidentStatusId) 
		VALUES('$_POST[callerName]','$_POST[contactNumber]','$_POST[incidentType]','$_POST[Location]','$_POST[incidentDesc]','1')";
		
		//echo $sql;
		if(!mysql_query($sql,$con))
			
			die('Error:'.mysql_error());
		
		mysql_close($con);
	}
?>
</head>
<body>

<?php 
					// localhost, accountName, password
$con =mysql_connect("localhost","ameera_pessdb","password123");
if(!$con)
{
	die('Connect connect to database :'.mysql_error());
}
				// databaseName
mysql_select_db("12_ameera_pessdb",$con);
$result = mysql_query("SELECT * FROM incidenttype");
$incidentType;

while($row = mysql_fetch_array($result))
{
	//incidentTypeId,incidentTypeDesc
	$incidentType[$row['incidentTypeId']] = $row['incidentTypeDesc'];

}
mysql_close($con);
?>
<br>
	<form name="frmlogcall" method="POST" onsubmit="return validateForm()" action="Dispatch.php">
		<fieldset>
			<legend>Log Call</legend>
<table>
	<tr>
		<td align="right">Caller's name:</td>
		<td><p><input type="text" name="callerName"/></p></td>
	</tr><br><br>
			
	<tr>
		<td align="right">Contact Number:</td>
		<td><p><input type="text" name="contactNumber"/></p></td>
	</tr><br><br>
			
	<tr>
		<td align="right">Location:</td>
		<td><p><input type="text" name="Location"></p></td>
	</tr>
				
			<tr></tr>
	<tr>
		<td align="right" class="td_label">Incident Type:</td>
		<td class="td_Date">
			<p>
			<select name="incidentType" id="incidentType">
				<?php foreach($incidentType as $key => $value){?>
					<option value="<?php echo $key?>"><?php echo $value ?></option>
				<?php } ?>
			</select>
			</p>
		</td>
	</tr>
	<tr>
		<td>Description:</td>
		<td><p><textarea name="incidentDesc" rows="5" cols="50"></textarea></p></td>
	</tr>
	<tr>
		<td><button type="reset" value="Reset">Reset</button></td>
		<td><button type="submit" name="btnProcessCall" value="Process Call">Process Call</button></td>
	</tr>
</table>
  <br><br>
		</fieldset>
	</form>
</body>
</html>