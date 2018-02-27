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

$rs = $db->Execute("select vehicleID, ownerID, capacity, inService, inUse, currentLatitude, currentLongitude from WeGoVehicleDB where vehicleID = " . reset($_GET));

print "{ </br>";
print "\"vehicleID\": " . $rs->fields['vehicleID'] . ", </br>";
print "\"ownerID\": " . $rs->fields['ownerID'] . ", </br>";
print "\"capacity\": " . $rs->fields['capacity'] . ", </br>";
print "\"inService\": " . $rs->fields['inService'] . ", </br>";
print "\"inUse\": " . $rs->fields['inUse'] . ", </br>";
print "\"currentLatitude\": " . $rs->fields['currentLatitude'] . ", </br>";
print "\"currentLongitude\": " . $rs->fields['currentLongitude'] . ", </br>";
print "} </br>";

?>