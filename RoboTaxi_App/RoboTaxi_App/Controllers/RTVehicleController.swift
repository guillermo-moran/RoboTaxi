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
                
                let json = try JSONSerialization.jsonObject(with: data, options: .allowFragments) as! [String:Any]
                
               
                //let posts = json["posts"] as? [[String: Any]] ?? []
                //let s = String(data: data, encoding: String.Encoding.utf8) as String!
                //print(s!)
                
                
                let vehicleID = json["vehicleID"] as! Int
                let ownerID = json["orderID"] as! Int
                let capacity = json["capacity"] as! Int
                let inService = json["inService"] as! Bool
                let inUse = json["isUse"] as! Bool
                let currentLatitude = json["currentLatitude"] as! Double
                let currentLongitude = json["currentLongitude"] as! Double
                
                
               let newVehicle = RTVehicle(vehicleID: vehicleID, ownerID: ownerID, capacity: capacity, inService: inService, inUse: inUse, currentLatitude: currentLatitude, currentLongitude: currentLongitude)
 
                
                vehiclesArray.append(newVehicle)
                //Signal semaphore after finishing
                sem.signal()
                
            } catch let error as NSError {
                print(error)
            }
        }
        task.resume()
        
        // This line will wait until the semaphore has been signaled
        // which will be once the data task has completed
        let _ = sem.wait(timeout: .distantFuture)

        return vehiclesArray
        
    }
    
    func returnFakeVehiclesInStEdwards() -> [RTVehicle] {
        
        var vehiclesArray : [RTVehicle] = []
        
        let fakeCoordinates = [
            [30.230808, -97.752050],
            
            [30.228769, -97.758295]
        ];
        
        for array in fakeCoordinates {
            let newVehicle = RTVehicle(vehicleID: 0, ownerID: 0, capacity: 2, inService: true, inUse: false, currentLatitude: array[0], currentLongitude: array[1])
            
            vehiclesArray.append(newVehicle);
        }
            
        return vehiclesArray
    }
    
}
