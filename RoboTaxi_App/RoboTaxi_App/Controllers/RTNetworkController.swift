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
    
    static let serverAddress  = "https://gmoran.create.stedwards.edu/RoboTaxi/Controller.php"
    static let requestTimeout = DispatchTime.distantFuture //DispatchTime.now() + .seconds(30)
    
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
        
        let sem = DispatchSemaphore(value: 0)
        
        let url = URL(string: RTNetworkController.serverAddress)
        var request = URLRequest(url: url!)
        request.httpMethod = "POST"
        
        
        
        let requestType = "AUTHENTICATE"; // "AUTHENTICATE" is the type to request a trip/vehicle from the server
        
        let postString = "user_name=\(username)&user_pass=\(password)&request_type=\(requestType)"
        
        request.httpBody = postString.data(using: .utf8)
        
        
        let task = URLSession.shared.dataTask(with: request) { data, response, error in
            guard let data = data, error == nil else {
                // check for fundamental networking error
                print("error=\(String(describing: error))")
                return ()
            }
            
            do {
                
                let json = try JSONSerialization.jsonObject(with: data, options: .allowFragments) as! [String:Any]
                //let posts = json["posts"] as? [[String: Any]] ?? []
                print(json)
                
                let status = json["status"] as! String

                if (status == "Authenticated") {
                    self.loggedIn = true
                    
                    if (!self.userAccountExistsOnDevice()) {
                        let keychain = KeychainSwift()
                        keychain.set(username, forKey: "com.WeGo.RoboTaxi.Username")
                        keychain.set(password, forKey: "com.WeGo.RoboTaxi.Password")
                    }
                }
                
                //Signal semaphore after finishing
                sem.signal()
                
                
            } catch let error as NSError {
                print(error)
            }
        }
        task.resume()
        
        // This line will wait until the semaphore has been signaled
        // which will be once the data task has completed
        let _ = sem.wait(timeout: RTNetworkController.requestTimeout)
        
        return loggedIn
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
    
    func logout() -> Bool {
        let keychain = KeychainSwift()
        
        if (keychain.delete("com.WeGo.RoboTaxi.Username") && keychain.delete("com.WeGo.RoboTaxi.Password")) {
            
            loggedIn = false
            
            return true
        }
        return false
    }
    
    func getUsername() -> String {
        let keychain = KeychainSwift()
        return keychain.get("com.WeGo.RoboTaxi.Username")!
        
    }
    func getPassword() -> String {
        let keychain = KeychainSwift()
        return keychain.get("com.WeGo.RoboTaxi.Password")!
    }
}
