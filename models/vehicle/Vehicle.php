<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 12.02.2018
 * Time: 15:36
 *
 * Data layer
 * https://tchallst.create.stedwards.edu/delorean/topics/dataLayer.php
 *
 * Useless file, might be deleted later on
 */


/**
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
 */

class Vehicle
{
    private $vehicleID;
    private $ownerID;
    private $capacity;
    private $inService;
    private $inUse;
    private $currentLatitude;
    private $currentLongitude;

    public function __construct(int $vehicleID, int $ownerID, int $capacity, bool $inService, bool $inUse, float $currentLatitude, float $currentLongitude)
    {
        $this -> vehicleID = $vehicleID;
        $this -> ownerID = $ownerID;
        $this -> capacity = $capacity;
        $this -> inService = $inService;
        $this -> inUse = $inUse;
        $this -> currentLatitude = $currentLatitude;
        $this -> currentLongitude = $currentLongitude;
    }

    // get functions
    public function getVehicleID() : int
    {
        return $this -> vehicleID;
    }

    public function getVehicleOwnerID() : int
    {
        return $this -> ownerID;
    }

    public function getVehicleCapacity() : int
    {
        return $this -> capacity;
    }

    public function getVehicleAvailability() : bool
    {
        return $this -> inService;
    }

    public function getVehicleBusyStatus() : bool
    {
        return $this -> inUse;
    }

    public function getVehicleCurrentLatitude() : float
    {
        return $this->currentLatitude;
    }

    public function getVehicleCurrentLongitude() : float
    {
        return $this->currentLongitude;
    }

    //set functions
    public function setVehicleID(Int $newVehicleID)
    {
        $this -> vehicleID =  $newVehicleID;
    }

    public function setVehicleOwnerID(Int $newVehicleOwnerID)
    {
        $this -> ownerID = $newVehicleOwnerID;
    }

    public function setVehicleCapacity(Int $newVehicleCapacity)
    {
        $this -> capacity = $newVehicleCapacity;
    }

    public function setVehicleAvailability(Bool $newStatus)
    {
        $this -> inService = $newStatus;
    }

    public function setVehicleBusyStatus(Bool $newStatus)
    {
        $this -> inUse = $newStatus;
    }

    public function setVehicleCurrentLatitude(float $newLatitude)
    {
        $this -> currentLatitude = $newLatitude;
    }

    public function setVehicleCurrentLongitude(float $newLongitude)
    {
        $this -> currentLongitude = $newLongitude;
    }
}