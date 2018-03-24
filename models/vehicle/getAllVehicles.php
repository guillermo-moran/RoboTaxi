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

$login = PHPcredentials();
$db = new mysqli($login[0], $login[1], $login[2], $login[3]);

$rs = $db->query("select count(*) from WeGoVehicleDB")->fetch_assoc();
$count = $rs['count(*)'];
//print $count;

for ($x = 1; $x <= 1024; $x++)
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

    if ($vehicle -> vehicleID != null)
    {
        $json = json_encode($vehicle);
        print $json;
    }
}

returnSuccess(null);
$db -> close();
?>