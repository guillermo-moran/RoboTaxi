//
//  VehicleOrderController.swift
//  RoboTaxi_App
//
//  Created by Guillermo Moran on 2/12/18.
//  Copyright © 2018 WeGo. All rights reserved.
//

import UIKit

class RTVehicleOrderController: NSObject {
    
    //private var newOrder : RTOrder = RTOrder()
    
    static let sharedInstance = RTVehicleOrderController()
    
    func isEmptyOrder(order : RTOrder) -> Bool {
        if(order.getOrderID() == -1) {
            return true
        }
        return false
    }
    
    func requestNewOrder(successHandler: @escaping (_ response: RTOrder) -> Void)  {
        
        let background = DispatchQueue.global()
        
        background.async {
            
            //var newOrder = RTOrder()
            
            //Semaphore create
            //let sem = DispatchSemaphore(value: 0)
            
            let url = URL(string: RTNetworkController.serverAddress)
            var request = URLRequest(url: url!)
            request.httpMethod = "POST"
            
            /*
             $userID              = $_POST["user_id"];
             $userPass             = $_POST["user_pass"];
             $userLocationLong     = $_POST["longitude"];
             $userLocationLat     = $_POST["latitude"];
             $userDate            = $_POST["date"];
             $destinationLong    = $_POST["dest_long"];
             $destinationLat       = $_POST["dest_lat"];
             */
            
            //Lets make up values for testing purposes. We'll fill these values in appropriately at a later date
            let userName = RTNetworkController.sharedInstance.getUsername()
            let userPass = RTNetworkController.sharedInstance.getPassword()
            let userLocationLong = RTUserLocation.sharedInstance.getUserLongitude()
            let userLocationLat = RTUserLocation.sharedInstance.getUserLatitude()
            let destinationLong = 1.0
            let destinationLat = 1.0
            let userDate = "N/A"
            
            let requestType = "ORDER"; // "ORDER" is the type to request a trip/vehicle from the server
            
            let postString = "user_name=\(userName)&user_pass=\(userPass)&user_latitude=\(userLocationLat)&user_longitude=\(userLocationLong)&date=\(userDate)&dest_lat=\(destinationLat)&dest_long=\(destinationLong)&request_type=\(requestType)"
            
            request.httpBody = postString.data(using: .utf8)
            
            let newOrder = RTOrder()
            
            let task = URLSession.shared.dataTask(with: request) { data, response, error in
                guard let data = data, error == nil else {
                    // check for fundamental networking error
                    print("error=\(String(describing: error))")
                    return ()
                }
                
                
                do {
                    
                    /*
                     Order structure as follows (swift):
                     
                     private let user_id : Int
                     private let order_id : Int
                     private let vehicle_id : Int
                     private let orderDate : String
                     private let startLatitude : Double
                     private let startLongitude : Double
                     private let endLatitude : Double
                     private let endLongitude : Double
                     
                     (php)
                     $newOrder->user_id = $user_id;
                     $newOrder->order_id = 0; //We'll fill these in soon
                     $newOrder->vehicle_id = 0; //We'll fill these in soon
                     $newOrder->orderDate = $user_date;
                     $newOrder->start_lat = $userLatitude;
                     $newOrder->start_long = $userLongitude;
                     $newOrder->end_lat = $destLatitude;
                     $newOrder->end_long = $destLongitude;
                     */
                    
                    let json = try JSONSerialization.jsonObject(with: data, options: .allowFragments) as! [String:Any]
                    //let posts = json["posts"] as? [[String: Any]] ?? []
                    print(json)
                    
                    let user_id = json["user_id"] as! Int
                    let order_id = json["order_id"] as! Int
                    let vehicle_dict = json["vehicle"] as! NSDictionary
                    let orderDate = json["orderDate"] as! String
                    let start_lat = json["start_lat"] as! Double
                    let start_long = json["start_long"] as! Double
                    let end_lat = json["end_lat"] as! Double
                    let end_long = json["end_long"] as! Double
                    
                    //let newOrder = RTOrder(order_id: order_id, user_id: user_id, vehicle_id: vehicle_id, orderDate: orderDate, startLatitude: start_lat, startLongitude: start_long, endLatitude: end_lat, endLongitude: end_long)
                    
                    let vehicleID = Int(vehicle_dict["vehicleID"] as! String)
                    let ownerID = Int(vehicle_dict["ownerID"] as! String)
                    let inUse = NSNumber(value: Int(vehicle_dict["inUse"] as! String)!)
                    let inService = NSNumber(value: Int(vehicle_dict["inService"] as! String)!)
                    let currentLongitude = Double(vehicle_dict["currentLongitude"] as! String)
                    let currentLatitude = Double(vehicle_dict["currentLatitude"] as! String)
                    let capacity = Int(vehicle_dict["capacity"] as! String)
                    
                    let requested_vehicle = RTVehicle(vehicleID: vehicleID!, ownerID: ownerID!, capacity: capacity!, inService: inService as! Bool, inUse: inUse as! Bool, currentLatitude: currentLatitude!, currentLongitude: currentLongitude!)
                    
                    //newOrder.setVehicle(vehicle: requested_vehicle)
                    
                    newOrder.setOrderID(orderID: order_id)
                    newOrder.setUserID(userID: user_id)
                    newOrder.setVehicle(vehicle: requested_vehicle)
                    newOrder.setOrderDate(date: orderDate)
                    newOrder.setStartLatitude(lat: start_lat)
                    newOrder.setStartLongitude(long: start_long)
                    newOrder.setEndLatitude(lat: end_lat)
                    newOrder.setEndLongitude(long: end_long)
                    
                    // Return the new order and vehicle
                    successHandler(newOrder as RTOrder!)
                    
                    
                    //Signal semaphore after finishing
                    //sem.signal()
                    
                    
                } catch let error as NSError {
                    print(error)
                }
            }
            task.resume()
        }
    }

}
