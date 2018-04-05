//
//  RTUserLocation.swift
//  RoboTaxi_App
//
//  Created by Guillermo Moran on 3/20/18.
//  Copyright © 2018 WeGo. All rights reserved.
//

import UIKit
import MapKit

class RTUserLocation: NSObject, CLLocationManagerDelegate {
    
    static let sharedInstance = RTUserLocation()
    
    private var userLocation = CLLocation()
    
    func getUserLatitude() -> Double {
        return userLocation.coordinate.latitude
    }
    
    func getUserLongitude() -> Double {
        return userLocation.coordinate.longitude
    }
    

}
