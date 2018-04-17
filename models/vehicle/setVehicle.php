<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 07.03.2018
 * Time: 21:36
 *
 * Actual functional PHP setVehicle
 * https://tchallst.create.stedwards.edu/delorean/topics/api.php
 */

require './sharedFunctions.php';
 
if (checkVehicleID($_GET['vehicleID']) == true)
{
	$login = PHPcredentials();
	$db = new mysqli($login[0], $login[1], $login[2], $login[3]);

	//check if ID exists in database
	$rs = $db->query("select * from WeGoVehicleDB where vehicleID = " . $_GET['vehicleID'] )->fetch_assoc();

	if ($rs['vehicleID'] == null) returnError("vehicleID not in database!");
	else
	{		
		$bigquery = "update WeGoVehicleDB set ";
		
		if (isset($_GET['ownerID']) and $_GET['ownerID'] != null)						$bigquery = $bigquery . "ownerID = "			. $_GET['ownerID'] . 			", ";
		if (isset($_GET['capacity']) and $_GET['capacity'] != null)						$bigquery = $bigquery . "capacity = "			. $_GET['capacity'] .			", ";
		if (isset($_GET['inService']) and $_GET['inService'] != null)					$bigquery = $bigquery . "inService = "			. $_GET['inService'] .			", ";
		if (isset($_GET['inUse']) and $_GET['inUse'] != null)							$bigquery = $bigquery . "inUse = "				. $_GET['inUse'] .				", ";
		if (isset($_GET['currentLatitude']) and $_GET['currentLatitude'] != null)		$bigquery = $bigquery . "currentLatitude = "	. $_GET['currentLatitude'] .	", ";
		if (isset($_GET['currentLongitude']) and $_GET['currentLongitude'] != null)		$bigquery = $bigquery . "currentLongitude = "	. $_GET['currentLongitude'] .	", ";
		
		$bigquery = $bigquery . "lastUpdate = '" . returnCurrentDateandTime() ."' where vehicleID = " . $_GET['vehicleID'];

		//DEBUG ONLY
		//print $bigquery . "\n\n";

		$check1 = true;
		$check2 = true;

		if ($_GET['inService'] < 0 or $_GET['inService'] > 1) $check1 = false;
		if ($_GET['inUse'] < 0 or $_GET['inUse'] > 1) $check2 = false;

		if ($check1 == true and $check2 == true)
		{
			$rs = $db->query($bigquery);
			returnSuccess("Vehicle data changed!");
		}
		else returnError("inService and/or inUse is not boolean!");
	}

	$db -> close();
}
else returnError("vehicleID is invalid!");
?>