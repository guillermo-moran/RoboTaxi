<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 24.02.2018
 * Time: 16:10
 */

// For debugging purposes
//var_dump($_GET);
//var_dump($_POST);

include('./adodb-5.20.9/adodb.inc.php');

$db = ADONewConnection('mysql');
$db->PConnect('localhost','meicherc_phpUser','KEvMLTly36','meicherc_dbs');

$rs = $db->Execute("select * from WeGoVehicleDB where vehicleID = " . reset($_GET));

$vehicle = new stdClass();

$vehicle -> vehicleID           = $rs->fields['vehicleID'];
$vehicle -> ownerID             = $rs->fields['ownerID'];
$vehicle -> capacity            = $rs->fields['capacity'];
$vehicle -> inService           = $rs->fields['inService'];
$vehicle -> inUse               = $rs->fields['inUse'];
$vehicle -> currentLatitude     = $rs->fields['currentLatitude'];
$vehicle -> currentLongitude    = $rs->fields['currentLongitude'];

$json = json_encode($vehicle);
echo $json;


?>