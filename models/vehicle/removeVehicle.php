<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 08.03.2018
 * Time: 17:21
 *
 * Actual functional PHP removeVehicle
 * https://tchallst.create.stedwards.edu/delorean/topics/api.php
 */

$db = new mysqli("localhost", "meicherc_WeGo", "erQ6340efSCf", "meicherc_WeGo");
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