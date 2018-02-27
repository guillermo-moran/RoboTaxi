//
//  VehicleOrderController.swift
//  RoboTaxi_App
//
//  Created by Guillermo Moran on 2/12/18.
//  Copyright © 2018 WeGo. All rights reserved.
//

import UIKit

class RTVehicleOrderController: NSObject {
    
    private var newOrder : RTOrder = RTOrder()
    
    static let sharedInstance = RTVehicleOrderController()
    
    func isEmptyOrder(order : RTOrder) -> Bool {
        if(order.getOrderID() == -1) {
            return true
        }
        return false
    }
    
    func requestNewOrder() -> RTOrder {
        
        //var newOrder = RTOrder()
        
        //Semaphore create
        let sem = DispatchSemaphore(value: 0)
        
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
        let userID = 0
        let userPass = "password"
        let userLocationLong = 0.0
        let userLocationLat = 0.0
        let destinationLong = 0.0
        let destinationLat = 0.0
        let userDate = "Today"
        
        let postString = "user_id=\(userID)&user_pass=\(userPass)&latitude=\(userLocationLat)&longitude=\(userLocationLong)&date=\(userDate)&dest_lat=\(destinationLat)&dest_long=\(destinationLong)"
        
        request.httpBody = postString.data(using: .utf8)
        
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
                let vehicle_id = json["vehicle_id"] as! Int
                let orderDate = json["orderDate"] as! String
                let start_lat = json["start_lat"] as! Double
                let start_long = json["start_long"] as! Double
                let end_lat = json["end_lat"] as! Double
                let end_long = json["end_long"] as! Double
                
                //let newOrder = RTOrder(order_id: order_id, user_id: user_id, vehicle_id: vehicle_id, orderDate: orderDate, startLatitude: start_lat, startLongitude: start_long, endLatitude: end_lat, endLongitude: end_long)
                
                self.newOrder.setOrderID(orderID: order_id)
                self.newOrder.setUserID(userID: user_id)
                self.newOrder.setVehicleID(vehicleID: vehicle_id)
                self.newOrder.setOrderDate(date: orderDate)
                self.newOrder.setStartLatitude(lat: start_lat)
                self.newOrder.setStartLongitude(long: start_long)
                self.newOrder.setEndLatitude(lat: end_lat)
                self.newOrder.setEndLongitude(long: end_long)
                
                //Signal semaphore after finishing
                sem.signal()
                
                
            } catch let error as NSError {
                print(error)
            }
        }
        task.resume()
        
        // This line will wait until the semaphore has been signaled
        // which will be once the data task has completed
        sem.wait(timeout: .distantFuture)
        
        print (self.newOrder.getOrderID())
        
        return self.newOrder
        
    }
    
    

}
