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
import AVFoundation



class RTMainScreenViewController: UIViewController, CLLocationManagerDelegate, MKMapViewDelegate {
    
    private var visibleVehicles : [RTVehicle] = []
    
    var player: AVAudioPlayer?
    
    let barColor = UIColor(red:0.32, green:0.36, blue:0.44, alpha:1.0)
    
    @IBOutlet weak var currentLocationBarView: UIView!
    @IBOutlet weak var profileButton: UIButton!
    @IBOutlet weak var mainMapView: MKMapView!
    @IBOutlet weak var requestVehicleButton: UIButton!
    @IBOutlet weak var currentLocationLabel: UILabel!
    
    @IBOutlet weak var searchField: UITextField!
    
    @IBOutlet weak var loadingView: UIView!
    
    @IBOutlet weak var notificationView: UIView!
    @IBOutlet weak var notificationViewTitle : UILabel!
    @IBOutlet weak var notificationViewSubtitle : UITextView!
    @IBOutlet weak var notificationViewCarID : UILabel!
    @IBOutlet weak var notificationBeginTripButton : UIButton!
    @IBOutlet weak var notificationViewDismissButton : UIButton!


    
    private var locationManager = CLLocationManager()
    private var userLocation = CLLocation()
    private var geocoder = KPRGeocoder()
    private var currentVehicle = RTVehicle()
    private var currentDestination = MKMapItem()
    
    
    
    let loc = RTUserLocation.sharedInstance
    
    /*
     ███╗   ██╗ ██████╗ ████████╗██╗███████╗    ██╗   ██╗██╗███████╗██╗    ██╗
     ████╗  ██║██╔═══██╗╚══██╔══╝██║██╔════╝    ██║   ██║██║██╔════╝██║    ██║
     ██╔██╗ ██║██║   ██║   ██║   ██║█████╗      ██║   ██║██║█████╗  ██║ █╗ ██║
     ██║╚██╗██║██║   ██║   ██║   ██║██╔══╝      ╚██╗ ██╔╝██║██╔══╝  ██║███╗██║
     ██║ ╚████║╚██████╔╝   ██║   ██║██║          ╚████╔╝ ██║███████╗╚███╔███╔╝
     ╚═╝  ╚═══╝ ╚═════╝    ╚═╝   ╚═╝╚═╝           ╚═══╝  ╚═╝╚══════╝ ╚══╝╚══╝
 */
    
    func playSound() {
        guard let url = Bundle.main.url(forResource: "ding", withExtension: "mp3") else { return }
        
        do {
            try AVAudioSession.sharedInstance().setCategory(AVAudioSessionCategoryPlayback)
            try AVAudioSession.sharedInstance().setActive(true)
            
            let player = try AVAudioPlayer(contentsOf: url)
            
            player.play()
            
        } catch let error {
            print(error.localizedDescription)
        }
    }
    
    func displayNotificationView(title : String, subtitle : String, carID : String, isCarNotification : Bool, dismissButtonTitle : String) {
        
        print ("DISPLAYING NOTIF VIEW")
        
        self.playSound()
        
        self.notificationView.isHidden = false
        
        notificationViewTitle.text = title
        notificationViewSubtitle.text = subtitle
        notificationViewCarID.text = carID
        notificationViewDismissButton.titleLabel!.text = "Cancel"
        
        if (isCarNotification) {
            notificationBeginTripButton.isHidden = false
        }
        else {
            notificationBeginTripButton.isHidden = true
        }
    }
    
    @IBAction func dismissDisplayNotification() {
        self.notificationView.isHidden = true
    }
    @IBAction func beginTripPressed(_ sender: Any) {
        
        DispatchQueue.global().async {
            self.beginVehicleRoute(vehicle: self.currentVehicle, destination: self.currentDestination)
        }
        
        self.dismissDisplayNotification()
    }
    
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
        
        hideLoading()
        
        // Do any additional setup after loading the view.
        initializeMapView()
        UIApplication.shared.statusBarStyle = .default

        
        let buttonColor = barColor
        let cornerRadius = CGFloat(10)
        let borderWidth = CGFloat(1)
        
        /*
        requestVehicleButton.titleLabel?.textColor = .white
        requestVehicleButton.backgroundColor = barColor
        requestVehicleButton.layer.cornerRadius = cornerRadius
        requestVehicleButton.layer.borderWidth = borderWidth
        requestVehicleButton.layer.borderColor = buttonColor.cgColor
        requestVehicleButton.alpha = 0.9
        */
        
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
      
        //Display current address
        
        var _ = Timer.scheduledTimer(timeInterval: 10, target: self, selector: #selector(self.getCurrentLocationAddress), userInfo: nil, repeats: true)
        //..getCurrentLocationAddress()
        
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func showLoading() {
        loadingView.isHidden = false
    }
    func hideLoading() {
        loadingView.isHidden = true
    }
    
    func showAlert(title : String, message : String) {
        let alert = UIAlertController(title: title, message: message, preferredStyle: UIAlertControllerStyle.alert)
        
        alert.addAction(UIAlertAction(title: "Okay", style: UIAlertActionStyle.default, handler: nil))
        self.present(alert, animated: true, completion: nil)
    }
    
    /*
     ██╗   ██╗██╗     █████╗  ██████╗████████╗██╗ ██████╗ ███╗   ██╗███████╗
     ██║   ██║██║    ██╔══██╗██╔════╝╚══██╔══╝██║██╔═══██╗████╗  ██║██╔════╝
     ██║   ██║██║    ███████║██║        ██║   ██║██║   ██║██╔██╗ ██║███████╗
     ██║   ██║██║    ██╔══██║██║        ██║   ██║██║   ██║██║╚██╗██║╚════██║
     ╚██████╔╝██║    ██║  ██║╚██████╗   ██║   ██║╚██████╔╝██║ ╚████║███████║
      ╚═════╝ ╚═╝    ╚═╝  ╚═╝ ╚═════╝   ╚═╝   ╚═╝ ╚═════╝ ╚═╝  ╚═══╝╚══════╝
    */
    
    @objc private func getCurrentLocationAddress() {
        
        let lat = loc.getUserLatitude()
        let lon = loc.getUserLongitude()
        
        print(lat)
        print(lon)
        KPRGeocoder().latLongToAddress(latitude: lat, longitude: lon, completion: {(result, error) -> Void in
            
            if error == nil {
                print("address: ", result!)
                var locationName = result!.components(separatedBy: ",")
                
                self.currentLocationLabel.text = locationName[0]
                
            }
                
            else {
                print(error!.description)
            }
            
            
        })
        
    }
    
    func requestVehicle(destination : MKMapItem) {
        
        showLoading()
        
        let orderController = RTVehicleOrderController.sharedInstance
        
        orderController.requestNewOrder(successHandler: {
            
            (newOrder) in
            
            if (orderController.isEmptyOrder(order: newOrder)) {
                
                //If the order is empty, an error occured. Tell the user.
                
                self.showAlert(title: "Error", message: "An Error Occurred While Processing Your Order")

                DispatchQueue.main.sync {
                    self.hideLoading()
                }
 
                return
            }
            
            
            let vehicle = newOrder.getVehicle()
            
            self.showAlert(title: "RoboTaxi", message: "Your vehicle is on it's way! \n\n Vehicle Number: \(vehicle.getVehicleID()) \n Capacity: \(vehicle.getCapacity())")
            
            DispatchQueue.main.sync {
                self.hideLoading()
            }
            
            sleep(5)
            self.summonVehicle(vehicle: vehicle, userDestination: destination)
            
        })
        
        
        
    }
    
    @IBAction func openUserSettings(_ sender: Any) {
        
        if (RTNetworkController.sharedInstance.logout()) {
            self.dismiss(animated: true, completion: nil)
        }
        //Log out for now
    }
    
    /*
 ███████╗███████╗ █████╗ ██████╗  ██████╗██╗  ██╗
 ██╔════╝██╔════╝██╔══██╗██╔══██╗██╔════╝██║  ██║
 ███████╗█████╗  ███████║██████╔╝██║     ███████║
 ╚════██║██╔══╝  ██╔══██║██╔══██╗██║     ██╔══██║
 ███████║███████╗██║  ██║██║  ██║╚██████╗██║  ██║
 ╚══════╝╚══════╝╚═╝  ╚═╝╚═╝  ╚═╝ ╚═════╝╚═╝  ╚═╝
 */
    
    
    var matchingItems: [MKMapItem] = [MKMapItem]()
    
    @IBAction func searchFieldReturn(_ sender: AnyObject) {
        _ = sender.resignFirstResponder()
        mainMapView.removeAnnotations(mainMapView.annotations)
        self.performSearch()
    }
    
    func performSearch() {
        
        matchingItems.removeAll()
        let request = MKLocalSearchRequest()
        request.naturalLanguageQuery = searchField.text
        request.region = mainMapView.region
        
        let search = MKLocalSearch(request: request)
        
        search.start(completionHandler: {(response, error) in
            
            if error != nil {
                print("Error occured in search: \(error!.localizedDescription)")
            } else if response!.mapItems.count == 0 {
                print("No matches found")
            } else {
                print("Matches found")
                
                for item in response!.mapItems {
                    print("Name = \(item.name)")
                    print("Phone = \(item.phoneNumber)")
                    
                    self.matchingItems.append(item as MKMapItem)
                    print("Matching items = \(self.matchingItems.count)")
                    
                    let annotation = MKPointAnnotation()
                    annotation.coordinate = item.placemark.coordinate
                    annotation.title = item.name
                    annotation.subtitle = "Tap + to request a ride"
                    self.mainMapView.addAnnotation(annotation)
                }
            }
        })
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
        //locationManager.stopUpdatingLocation()
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
        
        let coordinateRegion = MKCoordinateRegionMakeWithDistance(userLocation.coordinate, 0.5, 0.5)
        mainMapView.setRegion(coordinateRegion, animated: true)
        
        loadAllVehicleAnnotations()
        
        //Refresh map vehicles every 2 minutes
        
        
        var _ = Timer.scheduledTimer(timeInterval: 10, target: self, selector: #selector(self.loadAllVehicleAnnotations), userInfo: nil, repeats: true)
        
        //var _ = Timer.scheduledTimer(timeInterval: 5, target: self, selector: #selector(self.refreshVehicle), userInfo: nil, repeats: true)
        //refreshVehicle(vehicle: visibleVehicles[0])
        
        
    }
    
    /*
      █████╗ ███╗   ██╗███╗   ██╗ ██████╗ ████████╗ █████╗ ████████╗██╗ ██████╗ ███╗   ██╗███████╗
     ██╔══██╗████╗  ██║████╗  ██║██╔═══██╗╚══██╔══╝██╔══██╗╚══██╔══╝██║██╔═══██╗████╗  ██║██╔════╝
     ███████║██╔██╗ ██║██╔██╗ ██║██║   ██║   ██║   ███████║   ██║   ██║██║   ██║██╔██╗ ██║███████╗
     ██╔══██║██║╚██╗██║██║╚██╗██║██║   ██║   ██║   ██╔══██║   ██║   ██║██║   ██║██║╚██╗██║╚════██║
     ██║  ██║██║ ╚████║██║ ╚████║╚██████╔╝   ██║   ██║  ██║   ██║   ██║╚██████╔╝██║ ╚████║███████║
     ╚═╝  ╚═╝╚═╝  ╚═══╝╚═╝  ╚═══╝ ╚═════╝    ╚═╝   ╚═╝  ╚═╝   ╚═╝   ╚═╝ ╚═════╝ ╚═╝  ╚═══╝╚══════╝
    */
    
    private func removeAllVehiclesFromMap() {
        for annotation in mainMapView.annotations {
            if (annotation.isKind(of: RTVehicleAnnotation.self)) {
                mainMapView.removeAnnotation(annotation)
            }
        }
    }
    
    private func getAnnotationWithVehicle(vehicle : RTVehicle) -> RTVehicleAnnotation {
        
        var index = 0
        for case let existingAnnotation as RTVehicleAnnotation in self.mainMapView.annotations {
            
            if existingAnnotation.vehicleID == vehicle.getVehicleID() {
                index+=1
                existingAnnotation.image = #imageLiteral(resourceName: "blue_car")
                existingAnnotation.title = "Your Vehicle"
                existingAnnotation.subtitle = "On it's way!"
                
                //mainMapView.removeAnnotation(existingAnnotation)
                //mainMapView.addAnnotation(existingAnnotation)
                
                return mainMapView.annotations[index] as! RTVehicleAnnotation;
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
            pinAnnotationView?.canShowCallout = true
            
            
            let rightButton = UIButton(type: .contactAdd)
            rightButton.tag = annotation.hash
            
            pinAnnotationView?.rightCalloutAccessoryView = rightButton
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
                
                if (isUserVehicle) {
                    existingAnnotation.image = #imageLiteral(resourceName: "blue_car")
                    existingAnnotation.title = "Your Vehicle"
                    existingAnnotation.subtitle = "On it's way!"
                }
                else {
                    existingAnnotation.image = #imageLiteral(resourceName: "vehicle_icon")
                    existingAnnotation.title = "Vehicle"
                    existingAnnotation.subtitle = "Available"
                }
                
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
    
    @objc func loadAllVehicleAnnotations() {
        
        //mainMapView.removeAnnotations(mainMapView.annotations)
        self.removeAllVehiclesFromMap()
        self.visibleVehicles = []
        
        let background = DispatchQueue.global()
        let main = DispatchQueue.main
        
        background.async {
            let availableVehicles = RTVehicleController.sharedInstance.returnAllAvailableVehiclesInArea()
            
            //let availableVehicles = RTVehicleController.sharedInstance.returnFakeVehiclesInStEdwards()
            
            main.async {
                for vehicle in availableVehicles {
                    
                    self.placeVehicleOnMap(vehicle: vehicle, isUserVehicle: false)
                    self.visibleVehicles.append(vehicle)
                    
                }
            }
        }
    }
    
    @objc func refreshVehicle(vehicle : RTVehicle) {
        let updatedVehicle = RTVehicleController.sharedInstance.returnUpdatedVehicle(vehicle: vehicle)
        
        let annotation = getAnnotationWithVehicle(vehicle: updatedVehicle)
        
        annotation.coordinate = CLLocationCoordinate2DMake(updatedVehicle.getCurrentLatitude(), updatedVehicle.getCurrentLongitude())
        
        mainMapView.removeAnnotation(annotation)
        mainMapView.addAnnotation(annotation)
    }
    
    func mapView(_ mapView: MKMapView, annotationView view: MKAnnotationView, calloutAccessoryControlTapped control: UIControl) {
        
        let item = MKMapItem(placemark: MKPlacemark(coordinate: CLLocationCoordinate2DMake((view.annotation?.coordinate.latitude)!, (view.annotation?.coordinate.longitude)!), addressDictionary: nil))
        
        requestVehicle(destination: item)
    }
    
    /*
     ██████╗  ██████╗ ██╗   ██╗████████╗██╗███╗   ██╗ ██████╗
     ██╔══██╗██╔═══██╗██║   ██║╚══██╔══╝██║████╗  ██║██╔════╝
     ██████╔╝██║   ██║██║   ██║   ██║   ██║██╔██╗ ██║██║  ███╗
     ██╔══██╗██║   ██║██║   ██║   ██║   ██║██║╚██╗██║██║   ██║
     ██║  ██║╚██████╔╝╚██████╔╝   ██║   ██║██║ ╚████║╚██████╔╝
     ╚═╝  ╚═╝ ╚═════╝  ╚═════╝    ╚═╝   ╚═╝╚═╝  ╚═══╝ ╚═════╝
    */
    
   
    
    func summonVehicle(vehicle : RTVehicle, userDestination : MKMapItem) {
        
        //let vehicle = self.annotationWithVehicleID(id: 1)
        
        let vehicleSource = MKMapItem(placemark: MKPlacemark(coordinate: CLLocationCoordinate2DMake(vehicle.getCurrentLatitude(), vehicle.getCurrentLongitude()), addressDictionary: nil))
        
        let vehicleDestination = MKMapItem.forCurrentLocation()
        
        let cString = self.requestVehicleRoute(vehicle: vehicle, isUserVehicle: true, source: vehicleSource, destination: vehicleDestination)
        
        
        RTVehicleController.sharedInstance.requestVehicleRoute(vehicle: vehicle, routeCoordinateString: cString, successHandler: {
            (success) in
            
            if (success == true) {
                //self.showAlert(title: "Your Vehicle Has Arrived", message: "Please make your way to the blue vehicle on the map. \n\n Your vehicle should have the number \(vehicle.getVehicleID()) on it's side.")
                
                self.currentVehicle = vehicle
                self.currentDestination = userDestination
                
                DispatchQueue.main.sync {
                    self.displayNotificationView(title: "Your Vehicle has Arrived!", subtitle: "Please make your way to your vehicle marked with the number \(vehicle.getVehicleID())\n\n Once you are inside the vehicle, press \"Begin Trip\"", carID: String(vehicle.getVehicleID()), isCarNotification: true, dismissButtonTitle: "Cancel Trip")
                }
                
                
                
                
                //self.beginVehicleRoute(vehicle: vehicle, destination: userDestination)
                
                /*
                let alertController = UIAlertController(title: "Your Vehicle Has Arrived", message: "Please make your way to the blue vehicle on the map. \n\n Your vehicle should have the number \(vehicle.getVehicleID()) on it's side.", preferredStyle: .actionSheet)
                
                // Create the actions
                let okAction = UIAlertAction(title: "Begin Trip", style: UIAlertActionStyle.default) {
                    UIAlertAction in
                    
                    //DispatchQueue.main.async {
                    self.beginVehicleRoute(vehicle: self.vehicle, destination: self.destination)
                    //}
                    print("START TRIP")
                    
                }
                let cancelAction = UIAlertAction(title: "Cancel Trip", style: .destructive) {
                    UIAlertAction in
                    
                    //self.showAlert(title: "Cancelled", message: "Your trip has been cancelled.")
                }
                
                // Add the actions
                alertController.addAction(okAction)
                alertController.addAction(cancelAction)
                
                // Present the controller
                self.present(alertController, animated: true, completion: nil)
                */
                
                
            }
            else {
                self.showAlert(title: "Error", message: "Your vehicle has encountered an error.")
            }
            
        })
        
    }
    
    func beginVehicleRoute(vehicle : RTVehicle, destination : MKMapItem) {
        
        print ("Starting route...")
    
        //let vehicle = self.annotationWithVehicleID(id: 1)
        
        let source = MKMapItem.forCurrentLocation()
            
        let cString = self.requestVehicleRoute(vehicle: vehicle, isUserVehicle: true, source: source, destination: destination)
            
        
        RTVehicleController.sharedInstance.requestVehicleRoute(vehicle: vehicle, routeCoordinateString: cString, successHandler: {
                    (success) in
                    
            if (success == true) {
                //self.showAlert(title: "Arrived", message: "You have arrived at your destination")
                DispatchQueue.main.sync {
                    self.displayNotificationView(title: "You Have Arrived", subtitle: "Before leaving the vehicle, please make sure you collect your belongings.\n\n Total Charges: $0.00", carID: String(vehicle.getVehicleID()), isCarNotification: false, dismissButtonTitle: "End Trip")
                }
            }
            else {
                self.showAlert(title: "Error", message: "Your vehicle has encountered an error.")
            }
                    
     
        })
        
    }
    
    func moveCar(vehicle : RTVehicleAnnotation, destinationCoordinate : CLLocationCoordinate2D) {
        
        
        mainMapView.layer.removeAllAnimations()
        
        
        UIView.animate(withDuration: 1.0, delay: 0.0, options: [], animations: {
            print("animating!")
            vehicle.coordinate = destinationCoordinate
            
        }, completion: { (finished: Bool) in
            
        })
        
        
    }
    
    func requestVehicleRoute(vehicle : RTVehicle, isUserVehicle : Bool, source : MKMapItem, destination : MKMapItem) -> String {
        
        print ("Requesting route")
        var coordinatesString = ""
        
        let sem = DispatchSemaphore(value: 0)
        
        DispatchQueue.main.async {
            self.placeVehicleOnMap(vehicle: vehicle, isUserVehicle: isUserVehicle)
        }
        
        
        generateVehicleRoute(vehicle: vehicle, isUserVehicle: isUserVehicle, source: source, destination: destination, successHandler: {
            (route) in
            
            let pointCount = route.polyline.pointCount
            print(pointCount)
            
            
            DispatchQueue.main.async {
                for i in 0 ... pointCount - 1 {
                    //print("aaa")
                        let coordinate = MKCoordinateForMapPoint(route.polyline.points()[i])
                        //annotation.coordinate = coordinate
                        coordinatesString += "\(coordinate.latitude) \(coordinate.longitude) "
                    
                }
                sem.signal()
            }
        })
        
        //let coordinate = MKCoordinateForMapPoint(route.polyline.points()[pointCount - 1])
        //moveCar(vehicle: annotation, destinationCoordinate: coordinate)
        let _ = sem.wait(timeout: RTNetworkController.requestTimeout)
        return coordinatesString
        
    }
    
    private func removeAllRoutes() {
        for overlay in mainMapView.overlays {
            
            mainMapView.remove(overlay)
            
        }
    }
    
    private func generateVehicleRoute(vehicle : RTVehicle, isUserVehicle : Bool, source : MKMapItem, destination : MKMapItem, successHandler: @escaping (_ response: MKRoute) -> Void) {
        
        print ("generating route")
        
        let request = MKDirectionsRequest()
        //request.source = MKMapItem(placemark: MKPlacemark(coordinate: CLLocationCoordinate2DMake(30.228122, -97.754157), addressDictionary: nil))
        
        //request.source = MKMapItem.forCurrentLocation()
                
        //request.destination = MKMapItem(placemark: MKPlacemark(coordinate: CLLocationCoordinate2D(latitude: 30.245432, longitude: -97.751267), addressDictionary: nil))
        
        request.source = source
        request.destination = destination
        
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
            print ("calculating directions")
            let route = unwrappedResponse.routes[0]
            
            //Delayer.delay(bySeconds: 1) {
            self.removeAllRoutes()
            
            self.mainMapView.add(route.polyline)
            //}
            // Return the new order and vehicle
            print("route generated")
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
