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

require './sharedFunctions.php';

if (checkVehicleID($_GET['vehicleID']) == true)
{
    $login = PHPcredentials();
    $db = new mysqli($login[0], $login[1], $login[2], $login[3]);
    $rs = $db->query("select vehicleID from WeGoVehicleDB where vehicleID = " . $_GET['vehicleID'] )->fetch_assoc();

    if (count($rs) == 0)
    {
        returnError("vehicleID does not exist!");
    }
    else
    {
        $rs = $db->query("delete from WeGoVehicleDB where vehicleID = " . $_GET['vehicleID'] );
        returnSuccess(null);
    }


    $db -> close();
}
else returnError("vehicleID is invalid!");
?>