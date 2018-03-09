<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 08.03.2018
 * Time: 17:21
 *
 * Actual functional PHP makeVehicle
 * https://tchallst.create.stedwards.edu/delorean/topics/api.php
 *
 * Usage:   removeVehicle.php?vehicleID=12
 *          trying to delete vehicleID's that don't exist will be refused
 */


$db = new mysqli("localhost", "meicherc_phpUser", "KEvMLTly36", "meicherc_dbs");
$rs = $db->query("select vehicleID from WeGoVehicleDB where vehicleID = " . $_GET['vehicleID'] )->fetch_assoc();

if (count($rs) == 0)
{
    http_response_code(404);
    print "ERROR: vehicleID does not exists!";
}
else
{
    http_response_code(202);
    $rs = $db->query("delete from WeGoVehicleDB where vehicleID = " . $_GET['vehicleID'] );
    print "SUCCESS";
}


$db -> close();
?>