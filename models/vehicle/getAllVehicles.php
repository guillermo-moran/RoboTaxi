<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 22.03.2018
 * Time: 17:16
 *
 * Actual functional PHP getAllVehicles
 * https://tchallst.create.stedwards.edu/delorean/topics/api.php
 */
 
require './sharedFunctions.php';
header('Content-type: application/json');

$login = PHPcredentials();
$db = new mysqli($login[0], $login[1], $login[2], $login[3]);

$rs = $db->query("select count(*) from WeGoVehicleDB")->fetch_assoc();
$count = $rs['count(*)'];

$jsonAll = null;

for ($x = $minVehicleID; $x <= $maxVehicleID; $x++)
{
	$rs = $db->query("select * from WeGoVehicleDB where vehicleID = $x")->fetch_assoc();

	$vehicle = new stdClass();
	$vehicle -> vehicleID           = $rs['vehicleID'];
	$vehicle -> ownerID             = $rs['ownerID'];
	$vehicle -> capacity            = $rs['capacity'];
	$vehicle -> inService           = $rs['inService'];
	$vehicle -> inUse               = $rs['inUse'];
	$vehicle -> currentLatitude     = $rs['currentLatitude'];
	$vehicle -> currentLongitude    = $rs['currentLongitude'];	
	$vehicle -> lastUpdate		    = $rs['lastUpdate'];
	
	if ($vehicle -> vehicleID != null)
	{
		$json = json_encode($vehicle);
		if ($x == 1) $jsonAll = $json;
		else $jsonAll = $jsonAll . "\n" . $json;
	}
}
$db -> close();

print $jsonAll;
returnSuccess(null);
?>