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

//print $_GET['vehicleID'];

$db = new mysqli("localhost", "meicherc_WeGo", "erQ6340efSCf", "meicherc_WeGo");
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