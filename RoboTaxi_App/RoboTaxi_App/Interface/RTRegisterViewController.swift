//
//  RTRegisterViewController.swift
//  RoboTaxi_App
//
//  Created by Eduardo Perez on 4/16/18.
//  Copyright © 2018 WeGo. All rights reserved.
//

import UIKit
import WebKit

class RTRegisterViewController: UIViewController, WKUIDelegate {

    var webView: WKWebView!
    
    @IBOutlet weak var embeddedRegister_webKitView: WKWebView!
    
    
    // define URL constant
    //let URL_USER_REGISTER = URL(string: "http://malkhud2.create.stedwards.edu/wego/register.php")!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        // this MIGHT not work
        self.automaticallyAdjustsScrollViewInsets = false
        
        webView = WKWebView(frame: embeddedRegister_webKitView.frame, configuration: WKWebViewConfiguration() )
        self.embeddedRegister_webKitView.addSubview(webView)
        self.webView.allowsBackForwardNavigationGestures = true
        let myURL = URL(string: "http://www.malkhud2.create.stedwards.edu/wego/register.php")
        let myRequest = URLRequest(url: myURL!)
        webView.load(myRequest)
        
    }
    
    
    @IBAction func doneWithRegisGoToLogin_button(_ sender: Any) {
        
        // segue to login screen after successful sign up
        let goToRTLoginViewController = self.storyboard?.instantiateViewController(withIdentifier: "RTLoginViewController") as! RTLoginViewController
        
        // take us to the login
        self.present(goToRTLoginViewController, animated: true, completion: nil)
    }
    
    /*

    

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

    @IBAction func button_Register(_ sender: Any) {
        // gets rid of keyboard
        userName_textField.resignFirstResponder()
        password_textField.resignFirstResponder()

        // get the text from the field
        let username = userName_textField.text!
        let email = email_textField.text!
        let password = password_textField!
        
        var request = URLRequest(url: URL_USER_REGISTER)
        
        request.setValue("application/x-www-form-urlencoded", forHTTPHeaderField: "Content-Type")
        request.httpMethod = "POST"
        // define what's POSTed to register.php
        let postString = "user_name=\(username)&email=\(email)&password=\(password)"
        request.httpBody = postString.data(using: .utf8)
        // opens session
        let task = URLSession.shared.dataTask(with: request){
            data, response, error in guard let data = data, error == nil
                else{
                    print("error\(error as Optional)")
                    return
            }
            // checks for http errors
            if let httpStatus = response as? HTTPURLResponse, httpStatus.statusCode != 200{
                print("statusCode should be 200, but is \(httpStatus.statusCode)")
                print("response = \(response as Optional)")
            }
            
            let responseString = String(data: data, encoding: .utf8)
            print("responseString = \(responseString as Optional)")
        }
        task.resume()

     
    }
*/
}
