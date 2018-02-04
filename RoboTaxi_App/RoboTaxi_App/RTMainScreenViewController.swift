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


    @IBOutlet weak var mainMapView: MKMapView!
    @IBOutlet weak var requestVehicleButton: UIButton!
    
    
    
    var locationManager = CLLocationManager()
    var userLocation = CLLocation()
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        // Do any additional setup after loading the view.

        initializeMapView()
        
        
        
        let buttonColor = requestVehicleButton.titleLabel?.textColor
        let cornerRadius = CGFloat(10)
        let borderWidth = CGFloat(1)
        
        requestVehicleButton.backgroundColor = barColor
        requestVehicleButton.layer.cornerRadius = cornerRadius
        requestVehicleButton.layer.borderWidth = borderWidth
        requestVehicleButton.layer.borderColor = buttonColor?.cgColor
        requestVehicleButton.alpha = 0.7
        
        
    }
    
    func initializeMapView() {
        
        self.locationManager.requestWhenInUseAuthorization()
        self.locationManager.startUpdatingLocation()
        self.locationManager.delegate = self
        
        self.mainMapView.delegate = self;
        self.mainMapView.showsUserLocation = true;
        
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
        let coordinateRegion = MKCoordinateRegionMakeWithDistance(location.coordinate, 4000, 4000)
        mainMapView.setRegion(coordinateRegion, animated: false)
        locationManager.stopUpdatingLocation()
    }
    
    @IBAction func requestVehicle(_ sender: Any) {
    }
    

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */

}
