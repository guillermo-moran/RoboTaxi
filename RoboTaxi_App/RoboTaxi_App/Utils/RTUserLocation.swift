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
    let locationManager = CLLocationManager()
    
    var currentLongitude : Double
    var currentLatitude : Double

    
    override init() {
        self.locationManager.requestAlwaysAuthorization()
        self.locationManager.startUpdatingLocation()
        
        self.currentLatitude  = 0
        self.currentLongitude = 0
        
        super.init()
        
        if CLLocationManager.locationServicesEnabled() {
            locationManager.delegate = self
            locationManager.desiredAccuracy = kCLLocationAccuracyNearestTenMeters
            locationManager.startUpdatingLocation()
        }
        
    }
    
    func getUserLatitude() -> Double {
        return currentLatitude
    }
    
    func getUserLongitude() -> Double {
        return currentLongitude
    }
    
    func locationManager(_ manager: CLLocationManager, didUpdateLocations locations: [CLLocation]) {
        guard let locValue: CLLocationCoordinate2D = manager.location?.coordinate else { return }
        print("locations = \(locValue.latitude) \(locValue.longitude)")
        
        currentLatitude = locValue.latitude
        currentLongitude = locValue.longitude
        
    
    }

}
