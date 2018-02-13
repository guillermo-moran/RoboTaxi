//
//  Order.swift
//  RoboTaxi_App
//
//  Created by Guillermo Moran on 2/12/18.
//  Copyright © 2018 WeGo. All rights reserved.
//

import UIKit

class RTOrder: NSObject {
    
    private var order_id : Int
    private var user_id : Int
    private var vehicle_id : Int
    private var orderDate : String
    private var startLatitude : Double
    private var startLongitude : Double
    private var endLatitude : Double
    private var endLongitude : Double
    
    override init() {
        self.order_id       = -1
        self.user_id        = -1
        self.vehicle_id     = -1
        self.orderDate      = "N/A"
        self.startLatitude  = 0.0
        self.startLongitude = 0.0
        self.endLatitude    = 0.0
        self.endLongitude   = 0.0
        
        
        super.init()
    }
    
    init(order_id : Int, user_id : Int, vehicle_id : Int, orderDate : String, startLatitude : Double, startLongitude : Double, endLatitude : Double, endLongitude : Double) {
        
        self.order_id       = order_id
        self.user_id        = user_id
        self.vehicle_id     = vehicle_id
        self.orderDate      = orderDate
        self.startLatitude  = startLatitude
        self.startLongitude = startLongitude
        self.endLatitude    = endLatitude
        self.endLongitude   = endLongitude
        
        
        super.init()
        
    }
    
    // Getters
    
    func getOrderID() -> Int {
        return self.order_id
    }
    
    func getUserID() -> Int {
        return self.user_id
    }
    
    func getVehicleID() -> Int {
        return self.vehicle_id
    }
    
    func getOrderDate() -> String {
        return self.orderDate
    }
    
    func getStartLatitude() -> Double {
        return self.startLatitude
    }
    
    func getStartLongitude() -> Double {
        return self.startLongitude
    }
    
    func getEndLatitude() -> Double {
        return self.endLatitude
    }
    
    func getEndLongitude() -> Double {
        return self.endLongitude
    }
    
    // Setters
    
    func setOrderID(orderID : Int) {
        self.order_id = orderID
    }
    
    func setUserID(userID : Int) {
        self.user_id = userID
    }
    
    func setVehicleID(vehicleID : Int) {
        self.vehicle_id = vehicleID
    }
    
    func setOrderDate(date : String) {
        self.orderDate = date
    }
    
    func setStartLatitude(lat : Double) {
        self.startLatitude = lat
    }
    
    func setStartLongitude(long : Double) {
        self.startLongitude = long
    }
    
    func setEndLatitude(lat : Double) {
        self.endLatitude = lat
    }
    
    func setEndLongitude(long : Double) {
        self.endLongitude = long
    }

}
