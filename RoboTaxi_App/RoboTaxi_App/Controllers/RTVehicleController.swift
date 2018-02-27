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
    
    func returnAllAvailableVehiclesInArea() -> [RTVehicle] {
        
        var vehiclesArray : [RTVehicle] = [];
        
        //var newOrder = RTOrder()
        
        //Semaphore create
        let sem = DispatchSemaphore(value: 0)
        
        let url = URL(string: "http://meicher.create.stedwards.edu/WeGoVehicleDB/getVehicle.php?vehicleID=1")
        let request = URLRequest(url: url!)
        
        let task = URLSession.shared.dataTask(with: request) { data, response, error in
            guard let data = data, error == nil else {
                // check for fundamental networking error
                print("error=\(String(describing: error))")
                return ()
            }
            
            do {
                
                //let json = try JSONSerialization.jsonObject(with: data, options: .allowFragments) as! [String:Any]
                
                //let posts = json["posts"] as? [[String: Any]] ?? []
                let s = String(data: data, encoding: String.Encoding.utf8) as String!
                print(s!)
                
                /*
                 let user_id = json["user_id"] as! Int
                 let order_id = json["order_id"] as! Int
                 let vehicle_id = json["vehicle_id"] as! Int
                 let orderDate = json["orderDate"] as! String
                 let start_lat = json["start_lat"] as! Double
                 let start_long = json["start_long"] as! Double
                 let end_lat = json["end_lat"] as! Double
                 let end_long = json["end_long"] as! Double
                 */
                
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
        
        return vehiclesArray
        
    }
    
    func returnFakeVehiclesInStEdwards() -> [RTVehicle] {
        
        var vehiclesArray : [RTVehicle] = []
        
        let fakeCoordinates = [
            [30.230808, -97.752050],
            [30.228176, -97.755012],
            [30.228769, -97.758295]
        ];
        
        for array in fakeCoordinates {
            let newVehicle = RTVehicle(vehicleID: 0, ownerID: 0, capacity: 2, inService: true, inUse: false, currentLatitude: array[0], currentLongitude: array[1])
            
            vehiclesArray.append(newVehicle);
        }
            
        return vehiclesArray
    }
    
}
