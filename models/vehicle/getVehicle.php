<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 24.02.2018
 * Time: 16:10
 *
 * Actual functional PHP getVehicle
 */

$db = new mysqli("localhost", "meicherc_phpUser", "KEvMLTly36", "meicherc_dbs");
$rs = $db->query("select * from WeGoVehicleDB where vehicleID = " . reset($_GET) )->fetch_assoc();

$vehicle = new stdClass();

$vehicle -> vehicleID           = $rs['vehicleID'];
$vehicle -> ownerID             = $rs['ownerID'];
$vehicle -> capacity            = $rs['capacity'];
$vehicle -> inService           = $rs['inService'];
$vehicle -> inUse               = $rs['inUse'];
$vehicle -> currentLatitude     = $rs['currentLatitude'];
$vehicle -> currentLongitude    = $rs['currentLongitude'];

$json = json_encode($vehicle);
echo $json;

?>