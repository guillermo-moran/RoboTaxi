//
//  RTNetworkController.swift
//  RoboTaxi_App
//
//  Created by Guillermo Moran on 2/4/18.
//  Copyright © 2018 WeGo. All rights reserved.
//

import UIKit

class RTNetworkController: NSObject {
    
    static let sharedInstance = RTNetworkController()
    static let serverAddress  = "http://gmoran.create.stedwards.edu/RoboTaxi/OrderTest2.php"
    
    private var loggedIn : Bool
    
    override init() {
        loggedIn = false
        super.init()
        
        if (userAccountExistsOnDevice()) {
            let keychain = KeychainSwift()
            let rtUsername = keychain.get("com.WeGo.RoboTaxi.Username")
            let rtPassword = keychain.get("com.WeGo.RoboTaxi.Password")
            
            if (self.login(username: rtUsername!, password: rtPassword!)) {
                loggedIn = true
            }
        }
    }
    
    func login(username : String, password : String) -> Bool {
        return true
    }
    
    func testMainServerConnection() -> Bool {
        
        var success : Bool
        
        success = true
        
        
        
        return success
    }
    
    func userAccountExistsOnDevice() -> Bool {
        let keychain = KeychainSwift()
        //keychain.set("hello world", forKey: "my key")
        let rtUsername = keychain.get("com.WeGo.RoboTaxi.Username")
        
        if (rtUsername != nil) {
            return true
        }
        return false
    }
    
    func isLoggedIn() -> Bool {
        return loggedIn
    }
}
