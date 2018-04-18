//
//  RTRegisterViewController.swift
//  RoboTaxi_App
//
//  Created by Guillermo Moran on 2/3/18.
//  Copyright © 2018 WeGo. All rights reserved.
//

import UIKit

class RTRegisterViewController: UIViewController, UIWebViewDelegate {
    
    @IBOutlet weak var webView: UIWebView!
    @IBOutlet weak var loadingIndicator: UIActivityIndicatorView!
    
    
    
    @IBAction func dismiss(_ sender: Any) {
        
        self.dismiss(animated: true, completion: nil)
        
    }
    override func viewDidLoad() {
        super.viewDidLoad()
        
        
        let url = URL(string: "https://malkhud2.create.stedwards.edu/wego/register.php")!
        let myRequest = URLRequest(url: url)
//        UserDefaults.standard.register(defaults: ["UserAgent": "Custom-Agent"])
        webView.delegate = self
        webView.loadRequest(myRequest)
        
        //let x =
        
        
        webView.scalesPageToFit = false
        
        //webView.scrollView.setZoomScale(1.5, animated: false)
        
        
        

        // Do any additional setup after loading the view.
    }
    
    func webViewDidStartLoad(_ webView: UIWebView) {
        loadingIndicator.startAnimating()
    }
    
    func webViewDidFinishLoad(_ webView: UIWebView) {
        webView.stringByEvaluatingJavaScript(from: "var style = document.createElement('style'); style.innerHTML = 'form, .content { width: 80%; } .header { width: 80% }'; document.head.appendChild(style)")
        
        
        loadingIndicator.stopAnimating()
        
        
        if (webView.request?.url?.absoluteString == "https://malkhud2.create.stedwards.edu/wego/login.php") {
            
            let alertController = UIAlertController(title: "RoboTaxi", message: "Your account has been created!", preferredStyle: .alert)
            
            // Create the actions
            let okAction = UIAlertAction(title: "Okay", style: UIAlertActionStyle.default) {
                UIAlertAction in
                
                self.dismiss(webView)
            }
           
            
            // Add the actions
            alertController.addAction(okAction)
            
            
            // Present the controller
            self.present(alertController, animated: true, completion: nil)
            
            
        }
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
}


