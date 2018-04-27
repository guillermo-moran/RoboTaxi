<?php

/*
  █████╗ ██╗   ██╗████████╗██╗  ██╗
 ██╔══██╗██║   ██║╚══██╔══╝██║  ██║
 ███████║██║   ██║   ██║   ███████║
 ██╔══██║██║   ██║   ██║   ██╔══██║
 ██║  ██║╚██████╔╝   ██║   ██║  ██║
 ╚═╝  ╚═╝ ╚═════╝    ╚═╝   ╚═╝  ╚═╝
*/

class Auth {

	static public function verifyUserCredentials($user_name, $user_password, $requestType) {
		/*
		Create a cURL request to the auth server, recieve the response in json
		decode response and return accordingly
		*/

	    // Get cURL resource
	    $curl = curl_init();
	    // Set some options - we are passing in a useragent too here
	    curl_setopt_array($curl, array(
	        CURLOPT_RETURNTRANSFER => 1,
	        CURLOPT_URL => 'https://malkhud2.create.stedwards.edu/user/authenticate.php',
	        CURLOPT_USERAGENT => 'ROBOTAXI_CLIENT_1.0',
	        CURLOPT_POST => 1,
	        CURLOPT_POSTFIELDS => array(
	            'user_name' 		=> $user_name,
	            'password' 			=> $user_password
	        )
	    ));

	    $jsonResp = curl_exec($curl);

	    curl_close($curl);

	    $array = json_decode($jsonResp, true); //'true' returns an array instead of a json object

		if ($array['status'] === "Logged In") {

			if ($requestType === "AUTHENTICATE") {
				Status::returnStatus("Authenticated");
			}

			return true;
		}
		else {

			if ($requestType === "AUTHENTICATE") {
				Status::returnStatus("Authentication Failure");
			}

			return false;
		}


	}
}


?>
