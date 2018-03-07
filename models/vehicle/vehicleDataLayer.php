<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 27.02.2018
 * Time: 23:14
 *
 * Other functions will be added later, file seem unnecessary at the moment
 * https://tchallst.create.stedwards.edu/delorean/topics/dataLayer.php
 *
 * Another file that is supposed to be a data layer exists, purpose unknown
 */

class vehicleRepository
{
    public static function getVehicleByID(int $vehicleID) : vehicle
    {
        $vehicleID = Database::scrubQuery($coffee_id);
        $tmp = Database::runQuerySingle("SELECT * FROM WeGoVehicleDB WHERE vehicleID='$vehicleID'");
        if ($tmp) return new vehicle($tmp['vehicleID'], $tmp['$ownerID'], $tmp['$capacity'], $tmp['$inService'], $tmp['$inUse'], $tmp['$currentLatitude'], $tmp['$currentLongitude']);
    }


    public static function updateVehicle($newVehicle) : bool
    {
        $vehicleID = $newVehicle->getVehicleID();
        $ownerID = $newVehicle->getVehicleOwnerID();
        $capacity = $newVehicle->getVehicleCapacity();
        $inService = $newVehicle->getVehicleAvailability();
        $inUse = $newVehicle->getVehicleBusyStatus();

        $currentLatitude = $newVehicle->getVehicleCurrentLatitude();
        $currentLongitude = $newVehicle->getVehicleCurrentLongitude();
    }
}
?>