//
//  RTRegisterViewController.swift
//  RoboTaxi_App
//
//  Created by Guillermo Moran on 2/3/18.
//  Copyright © 2018 WeGo. All rights reserved.
//

import UIKit

class RTLoginViewController: UIViewController {
    
    @IBOutlet weak var userName_textField: UITextField!
    @IBOutlet weak var password_textField: UITextField!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        // Do any additional setup after loading the view.
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    
    @IBAction func button_logIn(_ sender: Any) {
        // get rid of keyboard
        userName_textField.resignFirstResponder()
        password_textField.resignFirstResponder()
      
        let goToRTMainViewController = self.storyboard?.instantiateViewController(withIdentifier: "RTMainScreenViewController") as! RTMainScreenViewController
        
        let user = userName_textField.text
        let pass = password_textField.text
        
        let networkController = RTNetworkController.sharedInstance
        
        let authenticated = networkController.login(username: user!, password: pass!)
        
        if (authenticated) {
            self.present(goToRTMainViewController, animated: true, completion: nil)
        }
        else {
            displayMessage(userMsg: "The Username or Password is Incorrect")
        }
        
    }

    func displayMessage(userMsg:String) -> Void {
        let alertController = UIAlertController(title: "Error", message: userMsg, preferredStyle: .alert)
        
        let OkAction = UIAlertAction(title: "OK", style: .default)
        {
            // this line takes you back to the main page
            (action:UIAlertAction!) in
            print("OK button clicked")
            DispatchQueue.main.async
                {
                    //self.dismiss(animated: true, completion: nil)
            }
            // thess lines above
        }
        
        alertController.addAction(OkAction)
        self.present(alertController, animated: true, completion: nil)
    }
    
}

