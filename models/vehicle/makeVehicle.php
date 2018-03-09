<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 08.03.2018
 * Time: 16:53
 *
 * Actual functional PHP makeVehicle
 * https://tchallst.create.stedwards.edu/delorean/topics/api.php
 *
 * Usage:   makeVehicle.php?vehicleID=12
 *          Set all parameters of the vehicle using setVehicle.php
 *          trying to make vehicleID's that already exist will be refused
 */

//print $_GET['vehicleID'];

$db = new mysqli("localhost", "meicherc_phpUser", "KEvMLTly36", "meicherc_dbs");
$rs = $db->query("select vehicleID from WeGoVehicleDB where vehicleID = " . $_GET['vehicleID'] )->fetch_assoc();

if (count($rs) > 0)
{
    http_response_code(400);
    print "ERROR: vehicleID already exists!";
}
else
{
    http_response_code(202);
    $rs = $db->query("INSERT INTO WeGoVehicleDB(vehicleID, ownerID, capacity, inService, inUse, currentLatitude, currentLongitude) VALUES (". $_GET['vehicleID'] .",0,0,0,0,0,0)");
    print "SUCCESS";
}


$db -> close();
?>