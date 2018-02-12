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
    private $in_service;
    private $in_use;
    private $current_location;

    public function __construct(int $vehicleID, int $ownerID, int $capacity, bool $in_service, bool $in_use, string $current_location)
    {
        $this -> vehicleID = $vehicleID;
        $this -> ownerID = $ownerID;
        $this -> capacity = $capacity;
        $this -> in_service = $in_service;
        $this -> in_use = $in_use;
        $this -> current_location = $current_location;
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
        return $this -> in_service;
    }

    public function getVehicleBusyStatus() : bool
    {
        return $this -> in_use;
    }

    public function getVehicleCurrentLocation() : string
    {
        return $this -> current_location;
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
        $this -> in_service = $newStatus;
    }

    public function setVehicleBusyStatus(Bool $newStatus)
    {
        $this -> in_use = $newStatus;
    }

    public function setVehicleCurrentLocation(String $newLocation)
    {
        $this -> current_location = $newLocation;
    }
}