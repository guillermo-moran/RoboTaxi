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
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }


}

