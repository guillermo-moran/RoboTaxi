//
//  RTVehicleController.swift
//  RoboTaxi_App
//
//  Created by Guillermo Moran on 2/26/18.
//  Copyright © 2018 WeGo. All rights reserved.
//

import UIKit

class RTVehicleController: NSObject {
    
    static let sharedInstance = RTVehicleController()
    
    func requestVehicleRoute(vehicle : RTVehicle, routeCoordinateString : String, successHandler: @escaping (_ response: Bool) -> Void)
    {
        print("Requesting route: \(routeCoordinateString)")
        //let background = DispatchQueue.global()
        
        //background.async {
            
            let url = URL(string: RTNetworkController.serverAddress)
            var request = URLRequest(url: url!)
            request.httpMethod = "POST"
            
            
            //Lets make up values for testing purposes. We'll fill these values in appropriately at a later date
            let userName    = RTNetworkController.sharedInstance.getUsername()
            let userPass    = RTNetworkController.sharedInstance.getPassword()
            let vehicleID   = vehicle.getVehicleID()
        
            //Remove " " (space) at the end of the string
            let coordinates = routeCoordinateString.replacingOccurrences(of: "\\s+$", with: "", options: .regularExpression)
        
           
            let requestType = "ROUTE_VEHICLE"; // "ROUTE_VEHICLE" is the type to request a trip/vehicle from the server
            
            let postString = "user_name=\(userName)&user_pass=\(userPass)&vehicleID=\(vehicleID)&route_coordinates=\(coordinates)&request_type=\(requestType)"
            
            request.httpBody = postString.data(using: .utf8)
            request.timeoutInterval = 10000000000000000000
            
            let task = URLSession.shared.dataTask(with: request) { data, response, error in
                guard let data = data, error == nil else {
                    // check for fundamental networking error
                    print("error=\(String(describing: error))")
                
                    return ()
                    
                }
                
                
                do {
                    
                    let json = try JSONSerialization.jsonObject(with: data, options: .allowFragments) as! [String:Any]
                    //let posts = json["posts"] as? [[String: Any]] ?? []
                    //print(json)
                    //print("fuck")
                    
                    let success = json["status"] as! String;
                    
                    if (success == "Success") {
                        successHandler(true)
                        print("route success")
                    }
                    else {
                        successHandler(false)
                        print("route fail")
                    }
                
                } catch let error as NSError {
                    print(error)
                }
            }
            task.resume()
        //}
    }
    
    func returnUpdatedVehicle(vehicle : RTVehicle) -> RTVehicle {
        let sem = DispatchSemaphore(value: 0)
        
        let url = URL(string: RTNetworkController.serverAddress)
        var request = URLRequest(url: url!)
        request.httpMethod = "POST"
        
        
        let requestType = "UPDATE_VEHICLE"; // "UPDATE_VEHICLE" is the type to request a trip/vehicle from the server
        let vehicleID = vehicle.getVehicleID()
        
        let postString = "request_type=\(requestType)&vehicleID=\(vehicleID)"
        
        request.httpBody = postString.data(using: .utf8)
        
        var updatedVehicle = RTVehicle()
        
        let task = URLSession.shared.dataTask(with: request) { data, response, error in
            guard let data = data, error == nil else {
                // check for fundamental networking error
                print("error=\(String(describing: error))")
                
                return ()
            }
            
            do {
                
                let vehicle_dict = try JSONSerialization.jsonObject(with: data, options: .allowFragments) as! [String:Any]
                //let posts = json["posts"] as? [[String: Any]] ?? []
                print(updatedVehicle)
                
                let vehicleID = Int(vehicle_dict["vehicleID"] as! String)
                let ownerID = Int(vehicle_dict["ownerID"] as! String)
                let inUse = NSNumber(value: Int(vehicle_dict["inUse"] as! String)!)
                let inService = NSNumber(value: Int(vehicle_dict["inService"] as! String)!)
                let currentLongitude = Double(vehicle_dict["currentLongitude"] as! String)
                let currentLatitude = Double(vehicle_dict["currentLatitude"] as! String)
                let capacity = Int(vehicle_dict["capacity"] as! String)
                
                updatedVehicle = RTVehicle(vehicleID: vehicleID!, ownerID: ownerID!, capacity: capacity!, inService: inService as! Bool, inUse: inUse as! Bool, currentLatitude: currentLatitude!, currentLongitude: currentLongitude!)
                
                //Signal semaphore after finishing
                sem.signal()
                
                
            } catch let error as NSError {
                print(error)
            }
        }
        task.resume()
        
        // This line will wait until the semaphore has been signaled
        // which will be once the data task has completed
        let _ = sem.wait(timeout: RTNetworkController.requestTimeout)
        
        return updatedVehicle
    }
    
    
    func returnAllAvailableVehiclesInArea() -> [RTVehicle]  {
        
        
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
        
        let userLocationLong = 1.0
        let userLocationLat = 1.0
        
        
        let requestType = "VEHICLE_LIST"; // "ORDER" is the type to request a trip/vehicle from the server
        
        let postString = "user_latitude=\(userLocationLat)&user_longitude=\(userLocationLong)&request_type=\(requestType)"
        
        request.httpBody = postString.data(using: .utf8)
        
        var vehiclesArray : [RTVehicle] = []
        
        let task = URLSession.shared.dataTask(with: request) { data, response, error in
            guard let data = data, error == nil else {
                // check for fundamental networking error
                print("error=\(String(describing: error))")
                return ()
            }
            
            
            do {
                let json = try JSONSerialization.jsonObject(with: data, options: .allowFragments) as! [String:Dictionary<String, Any>]
                //let posts = json["posts"] as? [[String: Any]] ?? []
                //print(json)
                
                let count = json.count
                
                for i in 1 ... count {
                    let vehicle_dict = json[String(i)]
                    
                    let vehicleID = Int(vehicle_dict!["vehicleID"] as! String)
                    let ownerID = Int(vehicle_dict!["ownerID"] as! String)
                    let inUse = NSNumber(value: Int(vehicle_dict!["inUse"] as! String)!)
                    let inService = NSNumber(value: Int(vehicle_dict!["inService"] as! String)!)
                    let currentLongitude = Double(vehicle_dict!["currentLongitude"] as! String)
                    let currentLatitude = Double(vehicle_dict!["currentLatitude"] as! String)
                    let capacity = Int(vehicle_dict!["capacity"] as! String)
                
                    let requested_vehicle = RTVehicle(vehicleID: vehicleID!, ownerID: ownerID!, capacity: capacity!, inService: inService as! Bool, inUse: inUse as! Bool, currentLatitude: currentLatitude!, currentLongitude: currentLongitude!)
                    
                    vehiclesArray.append(requested_vehicle)
                    
                }
                
               
                
                // Return the new order and vehicle
                //successHandler(vehiclesArray as [RTVehicle]!)
                
                
                //Signal semaphore after finishing
                sem.signal()
                
                
            } catch let error as NSError {
                print(error)
            }
        }
        task.resume()
        
        // This line will wait until the semaphore has been signaled
        // which will be once the data task has completed
        let _ = sem.wait(timeout: RTNetworkController.requestTimeout)
        
        //print (newOrder.getOrderID())
        
        return vehiclesArray
        //return newOrder
        
    }
    
    func returnFakeVehiclesInStEdwards() -> [RTVehicle] {
        
        var vehiclesArray : [RTVehicle] = []
        
        let fakeCoordinates = [
            //[30.230808, -97.752050],
            
            [30.228769, -97.758295]
        ];
        
        for array in fakeCoordinates {
            let newVehicle = RTVehicle(vehicleID: 1, ownerID: 0, capacity: 2, inService: true, inUse: false, currentLatitude: array[0], currentLongitude: array[1])
            
            vehiclesArray.append(newVehicle);
        }
            
        return vehiclesArray
    }
    
}
