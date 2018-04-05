//
//  RTVehicle.swift
//  RoboTaxi_App
//
//  Created by Guillermo Moran on 2/13/18.
//  Copyright © 2018 WeGo. All rights reserved.
//

import UIKit

class RTVehicle: NSObject {
    
    private var vehicleID : Int
    private var ownerID : Int
    private var capacity : Int
    private var inService : Bool
    private var inUse : Bool
    private var currentLatitude : Double
    private var currentLongitude : Double
    
    override init() {
        
        self.vehicleID = -1
        self.ownerID = -1
        self.capacity = 0
        self.inService = false
        self.inUse = false
        self.currentLatitude = 0
        self.currentLongitude = 0
        
        super.init()
        
    }
    
    init(vehicleID : Int, ownerID : Int, capacity : Int, inService : Bool, inUse : Bool, currentLatitude : Double, currentLongitude : Double) {
        
        self.vehicleID          = vehicleID
        self.ownerID            = ownerID
        self.capacity           = capacity
        self.inService          = inService
        self.inUse              = inUse
        self.currentLatitude    = currentLatitude
        self.currentLongitude   = currentLongitude
        
    }
    
    func getCapacity() -> Int {
        return self.capacity
    }
    
    func getVehicleID() -> Int {
        return self.vehicleID
    }
    
    func getCurrentLatitude() -> Double {
        return self.currentLatitude
    }
    
    func getCurrentLongitude() -> Double {
        return self.currentLongitude
    }
    
    func setCurrentLatitude(newLat : Double) {
        self.currentLatitude = newLat
    }
    
    func setCurrentLongitude(newLong : Double) {
        self.currentLongitude = newLong
    }

}
