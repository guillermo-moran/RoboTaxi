//
//  RTMainScreenViewController.swift
//  RoboTaxi_App
//
//  Created by Guillermo Moran on 2/3/18.
//  Copyright © 2018 WeGo. All rights reserved.
//

import UIKit
import MapKit

class RTMainScreenViewController: UIViewController, MKMapViewDelegate, CLLocationManagerDelegate {
    
    let barColor = UIColor(red:0.32, green:0.36, blue:0.44, alpha:1.0)


    
    @IBOutlet weak var currentLocationBarView: UIView!
    @IBOutlet weak var profileButton: UIButton!
    @IBOutlet weak var mainMapView: MKMapView!
    @IBOutlet weak var requestVehicleButton: UIButton!
    
    
    
    var locationManager = CLLocationManager()
    var userLocation = CLLocation()
    
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        
        // Hide the navigation bar on the this view controller
        self.navigationController?.setNavigationBarHidden(true, animated: animated)
    }
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        // Do any additional setup after loading the view.
        initializeMapView()
        UIApplication.shared.statusBarStyle = .default

        
        
        let buttonColor = barColor
        let cornerRadius = CGFloat(10)
        let borderWidth = CGFloat(1)
        
        requestVehicleButton.titleLabel?.textColor = .white
        requestVehicleButton.backgroundColor = barColor
        requestVehicleButton.layer.cornerRadius = cornerRadius
        requestVehicleButton.layer.borderWidth = borderWidth
        requestVehicleButton.layer.borderColor = buttonColor.cgColor
        requestVehicleButton.alpha = 0.9
        
        //Current Location Bar View
        currentLocationBarView.layer.cornerRadius = cornerRadius
        currentLocationBarView.layer.borderWidth = borderWidth
        currentLocationBarView.layer.borderColor = UIColor.white.cgColor
        currentLocationBarView.alpha = 0.9
        
        
        //Profile Button
        
        //profileButton.titleLabel?.textColor = .white
        profileButton.layer.cornerRadius = profileButton.frame.width * 0.5
        profileButton.layer.borderWidth = borderWidth
        profileButton.layer.borderColor = buttonColor.cgColor
        profileButton.alpha = 0.9
      
        
    }
    
    func initializeMapView() {
    
        self.locationManager.requestWhenInUseAuthorization()
        self.locationManager.startUpdatingLocation()
        self.locationManager.delegate = self
        
        self.mainMapView.delegate = self
        self.mainMapView.showsUserLocation = true
        
        //let coordinateRegion = MKCoordinateRegionMakeWithDistance(userLocation.coordinate, 0.5, 0.5)
        //mainMapView.setRegion(coordinateRegion, animated: true)
       
        
        
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    //locationManager Delegate
    
    func locationManager(_ manager: CLLocationManager, didUpdateLocations locations: [CLLocation]) {
        
        let location = locations.first!
        let coordinateRegion = MKCoordinateRegionMakeWithDistance(location.coordinate, 2500, 2500)
        mainMapView.setRegion(coordinateRegion, animated: false)
        locationManager.stopUpdatingLocation()
    }
    
   
    
    @IBAction func requestVehicle(_ sender: Any) {
    }
    
    //Uber-like movements
    
    //NOTE: Rewrite this in swift
    
    /*
     -(float)angleFromCoordinate:(CLLocationCoordinate2D)first toCoordinate:(CLLocationCoordinate2D)second {
 
        float deltaLongitude = second.longitude - first.longitude;
        float deltaLatitude = second.latitude - first.latitude;
        float angle = (M_PI * .5f) - atan(deltaLatitude / deltaLongitude);
 
        if (deltaLongitude > 0)      return angle;
        else if (deltaLongitude < 0) return angle + M_PI;
        else if (deltaLatitude < 0)  return M_PI;
 
        return 0.0f;
     }
     
     float getAngle = [self angleFromCoordinate:oldLocation toCoordinate:newLocation];
     
     //Apply the new location for coordinate.
     myAnnotation.coordinate = newLocation;
     
     //For getting the MKAnnotationView.
     AnnotationView *annotationView = (AnnotationView *)[self.mapView viewForAnnotation:myAnnotation];
     
     //Apply the angle for moving the car.
     annotationView.transform = CGAffineTransformMakeRotation(getAngle);
     
     
     */
    

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */

}
