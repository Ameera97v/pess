<?php
if(!isset($_POST["btnSearch"])){
	//retrieve patrol car status and patrolcarstatus
	//connect to a database
	$con=mysql_connect("localhost","ameera_pessdb","password123");
	if(!$con)
	{
		die('Cannot connect to database:'.mysql_error());
	}
	// select a table in the database
	mysql_select_db("12_ameera_pessdb",$con);
	
	//update patrol car status
	$sql="UPDATE patrolCar SET patrolCarStatusId = '"._POST["patrolCarStatus"]."'WHERE patrolCarId = '"._POST["patrolCarId"]."'";
	
	if(!mysql_query($sql,$con))
	{
		die('Error4:' .mysql_error());
	}
	//if patrol car status is on-site(4) the capture the time of arrival
if($_POST["patrolCarStatus"] == '3') {//else if patrol car status is FREE then capture the time of completion

//First, retrieve the incidentID from dispatch table handeled by that patrol car
$sql = "SELECT incidentID FROM dispatch WHERE timeCompleted is NULL and patrolCarId = '"._POST["patrolCarId"]."'";

$result = mysql_query($sql,$con);
$incidentId;

while($row = mysql_fetch_array($result))
{
	//patrolCarId,patrolCarStatusId
	$incidentId = $row ['incidentId'];
}

//echo $incidentId;

//Now then can update dispatch
$sql = "UPDATE dispatch SET timeCompleted=NOW() WHERE timeCompleted is NULL and patrolCarId ='".$_POST["patrolCarId"]."'";

if(!mysql_query($sql,$con))
{
	die('Error4;' .mysql_error());
}
}
mysql_close($con);
?>

<script type = "text/javascript">//window.location="./logcall.php";</script>
<?php }?>

<!DOCTYPE html>
<html>
<head>
<title>Update</title>
</head>

<body>
<?php
include 'head.php';
?>	

<?php
if(!isset($_POST["btnSearch"])){
?>

<!-- relate a form to seaech for patrol car based on id-->

<form name="form1" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
	<fieldset>
	<legend>Update Patrol Car</legend>
	
<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">

<tr>
	<td width="25%" class="td_label">Patrol Car ID:</td>
	<td width="25%" class="td_Data"><input type="text" name="patrolCarId" id="patrolCarId"></td>
	
	<!-- must validate for no empty entry at the Client side, HOW??? -->
	<td class="td_Data"><input type="submit" name="btnSearch" id="btnSearch" value="Search"></td>
	
</tr>
</table>
	</fieldset>
</form>
</head>
<body>

<?php
} else {
	//else $_POST["patrolCarId"];
	//retrieve patrol car status and patrolcarstatus
	//connect to a database
	$con=mysql_connect("localhost","ameera_pessdb","password123");
	if(!$con)
	{
		die('Cannot connect to database:'.mysql_error());
	}
	// select a table in the database
	mysql_select_db("12_ameera_pessdb",$con);
	//retrieve patrol car status
	//connect to a database
	$con = mysql_connect("localhost","ameera_pessdb","password123");
	if (!con)
	{
		die("Cannot connect to database:".mysql_error());
	}
	//select a table in the database
	mysql_select_db("12_ameera_pessdb",$con);
	//retrieve patrol car status
	//connect to a database
	$sql="SELECT * FROM patrolcar WHERE patrolCarId='"$_.POST['patrolCarId']."'";
	
	$result=mysql_query($sql,$con);
	$patrolCarId;
	$patrolCarStatusId;
	
	while($row=mysql_fetch_array($result))
	{
		// patrolCarId, patrolStatusId
		
		$patrolCarId=$row['patrolCarId'];
		$patrolCarStatusId=$row['patrolCarStatusId'];
	}
	//retrieve patrolcarstatus master table
	$sql="SELECT * FROM patrolcar_status";
	$result=mysql_query($sql,$con);
	$patrolCarStatusMaster;
	
	while($row=mysql_fetch_array($result))
	{
		//status,statusDesc
		//create an associative array of patrol car status master type
		
		$patrolCarStatusMaster[$row['statusId']]=$row['statusDesc'];
	}
	
	mysql_close($con);
?>
<!--display a form to update patrol car status also update incident status when patrol car status is FREE-->
<form name="form2" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
	<fieldset>
	<legend>Update Patrol Car</legend>
	
<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">

<tr>
<td width="25%" clas="td_label">Patrol Car ID:</td>
<td width="25%" class="td_Data"><input type="text" name="patrolCarId" id="patrolCarId"></td>
</tr>

<tr>
<td class="td_label">Status :</td>
<td width="td_Data"><select name="patrolCarStatus" id="$patrolCarStatus">

<?php foreach($patrolCarStatusMaster as $key=>$value){?>

	<option value="<?php echo $key?>"
	<?php if ($key==$patrolCarStatusId) {?>selected="selected"
	<?php }?>>
	<?php echo $value ?>
	</option>
	
<?php } ?>

</selected></td>
</tr>
</table>
<br/>

<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">

<tr>
<td width="46%" class="td_label"><input type="reset" name="btnCancel" value="Reset"></td>
<td width="46%" class="td_Data">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btnUpdate" id="btnUpdate" value="Update">
</td>
</tr>
</table>
	</fieldset>
</form>
<?php }?>
</body>
</html>