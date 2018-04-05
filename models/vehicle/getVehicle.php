<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 24.02.2018
 * Time: 16:10
 *
 * Actual functional PHP getVehicle
 * https://tchallst.create.stedwards.edu/delorean/topics/api.php
 */
 
require './sharedFunctions.php';

if (checkVehicleID($_GET['vehicleID']) == true)
{
	$login = PHPcredentials();
	$db = new mysqli($login[0], $login[1], $login[2], $login[3]);
	$rs = $db->query("select * from WeGoVehicleDB where vehicleID = " . $_GET['vehicleID'] )->fetch_assoc();

	$vehicle = new stdClass();

	$vehicle -> vehicleID           = $rs['vehicleID'];
	$vehicle -> ownerID             = $rs['ownerID'];
	$vehicle -> capacity            = $rs['capacity'];
	$vehicle -> inService           = $rs['inService'];
	$vehicle -> inUse               = $rs['inUse'];
	$vehicle -> currentLatitude     = $rs['currentLatitude'];
	$vehicle -> currentLongitude    = $rs['currentLongitude'];
	$vehicle -> lastUpdate		    = $rs['lastUpdate'];

	$json = json_encode($vehicle);


	if ($vehicle -> vehicleID == null)
	{
		returnError("vehicleID not in database!");
	}
	else
	{
		returnSuccess(null);
		print $json;
	}

	$db -> close();
}
else returnError("vehicleID is invalid!");
?>