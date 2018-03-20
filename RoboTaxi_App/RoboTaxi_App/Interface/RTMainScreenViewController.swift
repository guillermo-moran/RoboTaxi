//
//  RTMainScreenViewController.swift
//  RoboTaxi_App
//
//  Created by Guillermo Moran on 2/3/18.
//  Copyright © 2018 WeGo. All rights reserved.
//
// http://patorjk.com/software/taag/#p=display&f=ANSI%20Shadow&t=vc%20stuff

import UIKit
import MapKit

class RTMainScreenViewController: UIViewController, CLLocationManagerDelegate, MKMapViewDelegate {
    
    private var visibleVehicles : [RTVehicle] = []
    
    let barColor = UIColor(red:0.32, green:0.36, blue:0.44, alpha:1.0)
    
    @IBOutlet weak var currentLocationBarView: UIView!
    @IBOutlet weak var profileButton: UIButton!
    @IBOutlet weak var mainMapView: MKMapView!
    @IBOutlet weak var requestVehicleButton: UIButton!
    
    
    private var locationManager = CLLocationManager()
    private var userLocation = CLLocation()
    
    /*
     ██╗   ██╗ ██████╗    ███████╗████████╗██╗   ██╗███████╗███████╗
     ██║   ██║██╔════╝    ██╔════╝╚══██╔══╝██║   ██║██╔════╝██╔════╝
     ██║   ██║██║         ███████╗   ██║   ██║   ██║█████╗  █████╗
     ╚██╗ ██╔╝██║         ╚════██║   ██║   ██║   ██║██╔══╝  ██╔══╝
      ╚████╔╝ ╚██████╗    ███████║   ██║   ╚██████╔╝██║     ██║
       ╚═══╝   ╚═════╝    ╚══════╝   ╚═╝    ╚═════╝ ╚═╝     ╚═╝
    */
    
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
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    /*
     ██╗   ██╗██╗     █████╗  ██████╗████████╗██╗ ██████╗ ███╗   ██╗███████╗
     ██║   ██║██║    ██╔══██╗██╔════╝╚══██╔══╝██║██╔═══██╗████╗  ██║██╔════╝
     ██║   ██║██║    ███████║██║        ██║   ██║██║   ██║██╔██╗ ██║███████╗
     ██║   ██║██║    ██╔══██║██║        ██║   ██║██║   ██║██║╚██╗██║╚════██║
     ╚██████╔╝██║    ██║  ██║╚██████╗   ██║   ██║╚██████╔╝██║ ╚████║███████║
      ╚═════╝ ╚═╝    ╚═╝  ╚═╝ ╚═════╝   ╚═╝   ╚═╝ ╚═════╝ ╚═╝  ╚═══╝╚══════╝
    */
    
    @IBAction func requestVehicle(_ sender: Any) {
        
        let orderController = RTVehicleOrderController.sharedInstance
        
        orderController.requestNewOrder(successHandler: {
            
            (newOrder) in
            
            if (orderController.isEmptyOrder(order: newOrder)) {
                
                //If the order is empty, an error occured. Tell the user.

                
                let alert = UIAlertController(title: "Error", message: "An Error Occurred While Processing Your Order.", preferredStyle: UIAlertControllerStyle.alert)
                alert.addAction(UIAlertAction(title: "Okay", style: UIAlertActionStyle.default, handler: nil))
                self.present(alert, animated: true, completion: nil)
 
                return
            }
            
            
            let vehicle = newOrder.getVehicle()
            
            let alert = UIAlertController(title: "RoboTaxi", message: "Your vehicle has arrived! Please make your way to the blue vehicle on the map. \n\n Vehicle Number: \(vehicle.getVehicleID()) \n Capacity: \(vehicle.getCapacity())", preferredStyle: UIAlertControllerStyle.alert)
            
            alert.addAction(UIAlertAction(title: "Okay", style: UIAlertActionStyle.default, handler: nil))
            self.present(alert, animated: true, completion: nil)

            
            self.requestVehicleRoute(vehicle: vehicle, isUserVehicle: true)
            
            //self.moveCar(vehicle: self.annotationWithVehicleID(id: vehicle.getVehicleID()), destinationCoordinate: CLLocationCoordinate2DMake(30.245432,  -97.751267))
            
        })
        
    }
    
    @IBAction func openUserSettings(_ sender: Any) {
        
        if (RTNetworkController.sharedInstance.logout()) {
            
            
            self.dismiss(animated: true, completion: nil)
        }
        
        
        //Log out for now
        
        
    }
    
    
    
    /*
     ██╗      ██████╗  ██████╗ █████╗ ████████╗██╗ ██████╗ ███╗   ██╗
     ██║     ██╔═══██╗██╔════╝██╔══██╗╚══██╔══╝██║██╔═══██╗████╗  ██║
     ██║     ██║   ██║██║     ███████║   ██║   ██║██║   ██║██╔██╗ ██║
     ██║     ██║   ██║██║     ██╔══██║   ██║   ██║██║   ██║██║╚██╗██║
     ███████╗╚██████╔╝╚██████╗██║  ██║   ██║   ██║╚██████╔╝██║ ╚████║
     ╚══════╝ ╚═════╝  ╚═════╝╚═╝  ╚═╝   ╚═╝   ╚═╝ ╚═════╝ ╚═╝  ╚═══╝
    */
    
    //Location didUpdateLocations delegate
    func locationManager(_ manager: CLLocationManager, didUpdateLocations locations: [CLLocation]) {
        
        let location = locations.first!
        let coordinateRegion = MKCoordinateRegionMakeWithDistance(location.coordinate, 2500, 2500)
        mainMapView.setRegion(coordinateRegion, animated: false)
        locationManager.stopUpdatingLocation()
    }
    
    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */
    
    /*
     ███╗   ███╗ █████╗ ██████╗
     ████╗ ████║██╔══██╗██╔══██╗
     ██╔████╔██║███████║██████╔╝
     ██║╚██╔╝██║██╔══██║██╔═══╝
     ██║ ╚═╝ ██║██║  ██║██║
     ╚═╝     ╚═╝╚═╝  ╚═╝╚═╝
     */
    
    func initializeMapView() {
        
        self.locationManager.requestWhenInUseAuthorization()
        self.locationManager.startUpdatingLocation()
        self.locationManager.delegate = self
        
        self.mainMapView.delegate = self
        self.mainMapView.showsUserLocation = true
        
        //Set custom map overlay
        //let tiileOverlay = PandaTiileOverlay(hasLabels: false, style: .light)
        //self.mainMapView.add(tiileOverlay.overlay, level: .aboveRoads) // .aboveLabels
        
        //let coordinateRegion = MKCoordinateRegionMakeWithDistance(userLocation.coordinate, 0.5, 0.5)
        //mainMapView.setRegion(coordinateRegion, animated: true)
        
        loadAllVehicleAnnotations()
        
    }
    
    /*
      █████╗ ███╗   ██╗███╗   ██╗ ██████╗ ████████╗ █████╗ ████████╗██╗ ██████╗ ███╗   ██╗███████╗
     ██╔══██╗████╗  ██║████╗  ██║██╔═══██╗╚══██╔══╝██╔══██╗╚══██╔══╝██║██╔═══██╗████╗  ██║██╔════╝
     ███████║██╔██╗ ██║██╔██╗ ██║██║   ██║   ██║   ███████║   ██║   ██║██║   ██║██╔██╗ ██║███████╗
     ██╔══██║██║╚██╗██║██║╚██╗██║██║   ██║   ██║   ██╔══██║   ██║   ██║██║   ██║██║╚██╗██║╚════██║
     ██║  ██║██║ ╚████║██║ ╚████║╚██████╔╝   ██║   ██║  ██║   ██║   ██║╚██████╔╝██║ ╚████║███████║
     ╚═╝  ╚═╝╚═╝  ╚═══╝╚═╝  ╚═══╝ ╚═════╝    ╚═╝   ╚═╝  ╚═╝   ╚═╝   ╚═╝ ╚═════╝ ╚═╝  ╚═══╝╚══════╝
    */
    
    private func annotationWithVehicleID(id : Int) -> RTVehicleAnnotation {
        for case let existingAnnotation as RTVehicleAnnotation in self.mainMapView.annotations {
            
            if existingAnnotation.vehicleID == id {
                
                existingAnnotation.image = #imageLiteral(resourceName: "blue_car")
                existingAnnotation.title = "Your Vehicle"
                existingAnnotation.subtitle = "On it's way!"
                
                mainMapView.removeAnnotation(existingAnnotation)
                mainMapView.addAnnotation(existingAnnotation)
                
                return existingAnnotation;
            }
        }
        let x = RTVehicleAnnotation()
        return x
    }
    
    func mapView(_ mapView: MKMapView, viewFor annotation: MKAnnotation) -> MKAnnotationView? {
        if annotation.isKind(of: MKUserLocation.self) {  //Handle user location annotation..
            return nil  //Default is to let the system handle it.
        }
        
        if !annotation.isKind(of: RTVehicleAnnotation.self) {  //Handle non-ImageAnnotations..
            var pinAnnotationView = mapView.dequeueReusableAnnotationView(withIdentifier: "DefaultPinView")
            if pinAnnotationView == nil {
                pinAnnotationView = MKPinAnnotationView(annotation: annotation, reuseIdentifier: "DefaultPinView")
            }
            return pinAnnotationView
        }
        
        //Handle ImageAnnotations..
        var view: RTVehicleAnnotationView? = mapView.dequeueReusableAnnotationView(withIdentifier: "imageAnnotation") as? RTVehicleAnnotationView
        if view == nil {
            view = RTVehicleAnnotationView(annotation: annotation, reuseIdentifier: "imageAnnotation")
        }
        
        let annotation = annotation as! RTVehicleAnnotation
        view?.image = annotation.image
        view?.annotation = annotation
        
        return view
    }
    
    
    func placeVehicleOnMap(vehicle : RTVehicle, isUserVehicle : Bool) {
        
        
        for case let existingAnnotation as RTVehicleAnnotation in self.mainMapView.annotations {
            
            if existingAnnotation.vehicleID == vehicle.getVehicleID() {
                
                existingAnnotation.image = #imageLiteral(resourceName: "blue_car")
                existingAnnotation.title = "Your Vehicle"
                existingAnnotation.subtitle = "On it's way!"
                
                mainMapView.removeAnnotation(existingAnnotation)
                mainMapView.addAnnotation(existingAnnotation)
                
                return;
            }
        }
        
        let annotation = RTVehicleAnnotation()
        annotation.coordinate = CLLocationCoordinate2DMake(vehicle.getCurrentLatitude(), vehicle.getCurrentLongitude())
        
        annotation.vehicleID = vehicle.getVehicleID()
        
        if (isUserVehicle) {
            annotation.image = #imageLiteral(resourceName: "blue_car")
            annotation.title = "Your Vehicle"
            annotation.subtitle = "On it's way!"
        }
        else {
            annotation.image = #imageLiteral(resourceName: "vehicle_icon")
            annotation.title = "Vehicle"
            annotation.subtitle = "Available"
        }
        
        self.mainMapView.addAnnotation(annotation)
        
        
    }
    
    
    func loadAllVehicleAnnotations() {
        
        let availableVehicles = RTVehicleController.sharedInstance.returnAllAvailableVehiclesInArea()
        
        for vehicle in availableVehicles {
            
            self.placeVehicleOnMap(vehicle: vehicle, isUserVehicle: false)
            
        }
        
    
    }
    
    /*
     ██████╗  ██████╗ ██╗   ██╗████████╗██╗███╗   ██╗ ██████╗
     ██╔══██╗██╔═══██╗██║   ██║╚══██╔══╝██║████╗  ██║██╔════╝
     ██████╔╝██║   ██║██║   ██║   ██║   ██║██╔██╗ ██║██║  ███╗
     ██╔══██╗██║   ██║██║   ██║   ██║   ██║██║╚██╗██║██║   ██║
     ██║  ██║╚██████╔╝╚██████╔╝   ██║   ██║██║ ╚████║╚██████╔╝
     ╚═╝  ╚═╝ ╚═════╝  ╚═════╝    ╚═╝   ╚═╝╚═╝  ╚═══╝ ╚═════╝
    */
    
    
    
    func moveCar(vehicle : RTVehicleAnnotation, destinationCoordinate : CLLocationCoordinate2D) {
        UIView.animate(withDuration: 20, animations: {
            vehicle.coordinate = destinationCoordinate
            self.mainMapView.removeAnnotation(vehicle)
            self.mainMapView.addAnnotation(vehicle)

        }, completion:  { success in
            if success {
                // handle a successfully ended animation
                //self.resetCarPosition()
            } else {
                // handle a canceled animation, i.e move to destination immediately
                vehicle.coordinate = destinationCoordinate
                self.mainMapView.removeAnnotation(vehicle)
                self.mainMapView.addAnnotation(vehicle)
            }
        })
    }
    
    func requestVehicleRoute(vehicle : RTVehicle, isUserVehicle : Bool) {
        
        let annotation = RTVehicleAnnotation()
    
        
        DispatchQueue.main.async {
            self.placeVehicleOnMap(vehicle: vehicle, isUserVehicle: isUserVehicle)
        }
        
        
        generateVehicleRoute(vehicle: vehicle, isUserVehicle: isUserVehicle, successHandler: {
            (route) in
            
            let pointCount = route.polyline.pointCount
            print(pointCount)
            
            
            DispatchQueue.main.async {
                for i in 0 ... pointCount - 1 {
                    //print("aaa")
                        let coordinate = MKCoordinateForMapPoint(route.polyline.points()[i])
                        annotation.coordinate = coordinate
                    
                }
            }
        })
        
        //let coordinate = MKCoordinateForMapPoint(route.polyline.points()[pointCount - 1])
        //moveCar(vehicle: annotation, destinationCoordinate: coordinate)
        
    }
    
    
    private func generateVehicleRoute(vehicle : RTVehicle, isUserVehicle : Bool, successHandler: @escaping (_ response: MKRoute) -> Void) {
        
        let request = MKDirectionsRequest()
        request.source = MKMapItem(placemark: MKPlacemark(coordinate: CLLocationCoordinate2DMake(30.228122, -97.754157), addressDictionary: nil))
        
        
        request.destination = MKMapItem(placemark: MKPlacemark(coordinate: CLLocationCoordinate2D(latitude: 30.245432, longitude: -97.751267), addressDictionary: nil))
        request.requestsAlternateRoutes = true
        request.transportType = .automobile
        
        let directions = MKDirections(request: request)
        
        directions.calculate { [unowned self] response, error in
            guard let unwrappedResponse = response else { return }
            
            /*
            for route in unwrappedResponse.routes {
                
                self.mainMapView.add(route.polyline)
                theRoute = route
                break
               // self.mainMapView.setVisibleMapRect(route.polyline.boundingMapRect, animated: true)
            }
            */
            let route = unwrappedResponse.routes[0]
            
            //Delayer.delay(bySeconds: 1) {
            self.mainMapView.add(route.polyline)
            //}
            // Return the new order and vehicle
            successHandler(route as MKRoute!)
        }
        
    }
    
    func mapView(_ mapView: MKMapView, rendererFor overlay: MKOverlay) -> MKOverlayRenderer {
        let renderer = MKPolylineRenderer(polyline: overlay as! MKPolyline)
        renderer.strokeColor = UIColor.blue
        return renderer
    }
    
}

/*
extension RTMainScreenViewController: MKMapViewDelegate {
    func mapView(_ mapView: MKMapView, rendererFor overlay: MKOverlay) -> MKOverlayRenderer {
        guard let tileOverlay = overlay as? MKTileOverlay else {
            return MKOverlayRenderer()
        }
        return MKTileOverlayRenderer(tileOverlay: tileOverlay)
    }
}
 */
