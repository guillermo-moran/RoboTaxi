<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 12.02.2018
 * Time: 15:36
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

    public function getVehicleCurrentLocation() : array
    {
        $tmp = array($this->currentLatitude, $this->currentLongitude);
        return $tmp;
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

    public function setVehicleCurrentLocation(float $newLongitude, float $newLatitude)
    {
        $this -> currentLongitude = $newLongitude;
        $this -> currentLatitude = $newLatitude;
    }
}