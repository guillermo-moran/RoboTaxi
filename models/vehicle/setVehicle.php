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
        $dateAndTime = returnCurrentDateandTime();
		
		$bigquery = "update WeGoVehicleDB
		set ownerID = ". $_GET['ownerID'] .",
		capacity = ". $_GET['capacity'] .",
		inService = ". $_GET['inService'] .",
		inUse = ". $_GET['inUse'] .",
		currentLatitude = ". $_GET['currentLatitude'] .",
		currentLongitude = ". $_GET['currentLongitude'] .",
		lastUpdate = '" . $dateAndTime ."' where vehicleID = " . $_GET['vehicleID'];

		print $bigquery;

		if ($_GET['ownerID'] != null and $_GET['capacity'] != null and $_GET['inService'] != null and $_GET['inUse'] != null and $_GET['currentLatitude'] != null and $_GET['currentLongitude'] != null)
		{
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
		else returnError("Missing parameters!");
	}

	$db -> close();
}
else returnError("vehicleID is invalid!");
?>