//
//  ViewController.swift
//  RoboTaxi_App
//
//  Created by Guillermo Moran on 2/3/18.
//  Copyright © 2018 WeGo. All rights reserved.
//

import UIKit

class RTWelcomeViewController: UIViewController {
    
    @IBOutlet weak var loginButton: UIButton!
    @IBOutlet weak var signupButton: UIButton!
    

    override func viewDidLoad() {
        super.viewDidLoad()
        setupButtons()
        
        
        
        // Do any additional setup after loading the view, typically from a nib.
        
    }
    
    
    func setupButtons () {
        
        let buttonColor = loginButton.titleLabel?.textColor
        let cornerRadius = CGFloat(10)
        let borderWidth = CGFloat(1)
        
        loginButton.backgroundColor = .clear
        loginButton.layer.cornerRadius = cornerRadius
        loginButton.layer.borderWidth = borderWidth
        loginButton.layer.borderColor = buttonColor?.cgColor
        
        signupButton.backgroundColor = .clear
        signupButton.layer.cornerRadius = cornerRadius
        signupButton.layer.borderWidth = borderWidth
        signupButton.layer.borderColor = buttonColor?.cgColor
    }
    
    @IBAction func loginButtonPressed(_ sender: Any) {
        
        if (RTNetworkController.sharedInstance.isLoggedIn()) {
            
            let goToRTMainViewController = self.storyboard?.instantiateViewController(withIdentifier: "RTMainScreenViewController") as! RTMainScreenViewController
            
            self.present(goToRTMainViewController, animated: true, completion: nil)
            
        }
        else {
            
            let goToLoginViewController = self.storyboard?.instantiateViewController(withIdentifier: "RTLoginViewController") as! RTLoginViewController
            
            self.present(goToLoginViewController, animated: true, completion: nil)
            
        }
        
    }
    
    @IBAction func signupButtonPressed(_ sender: Any) {
        
        /*
        let alert = UIAlertController(title: "Coming Soon!", message: "This feature is still being worked on.", preferredStyle: UIAlertControllerStyle.alert)
        alert.addAction(UIAlertAction(title: "Okay", style: UIAlertActionStyle.default, handler: nil))
        self.present(alert, animated: true, completion: nil)
        */
        
        let goToRegViewController = self.storyboard?.instantiateViewController(withIdentifier: "RTRegisterViewController") as! RTRegisterViewController
        
        self.present(goToRegViewController, animated: true, completion: nil)
        
        
    }
    
    
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }


}

