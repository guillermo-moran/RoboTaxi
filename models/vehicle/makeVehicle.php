<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 08.03.2018
 * Time: 16:53
 *
 * Actual functional PHP makeVehicle
 * https://tchallst.create.stedwards.edu/delorean/topics/api.php
 */

require './sharedFunctions.php';
 
if (checkVehicleID($_GET['vehicleID']) == true)
{ 
	$login = PHPcredentials();
	$db = new mysqli($login[0], $login[1], $login[2], $login[3]);
	$rs = $db->query("select vehicleID from WeGoVehicleDB where vehicleID = " . $_GET['vehicleID'] )->fetch_assoc();

	if (count($rs) > 0) returnError("vehicleID already exists!");
	else
	{
		$rs = $db->query("INSERT INTO WeGoVehicleDB(vehicleID, ownerID, capacity, inService, inUse, currentLatitude, currentLongitude, lastUpdate) VALUES (". $_GET['vehicleID'] .",0,0,0,0,0,0,'" . returnCurrentDateandTime() ."')");
		returnSuccess("Vehicle created!");
	}

	$db -> close();
}
else returnError("vehicleID is invalid!");
?>