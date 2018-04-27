<?php

/*
  ██████╗ ██████╗ ██████╗ ███████╗██████╗ ███████╗
 ██╔═══██╗██╔══██╗██╔══██╗██╔════╝██╔══██╗██╔════╝
 ██║   ██║██████╔╝██║  ██║█████╗  ██████╔╝███████╗
 ██║   ██║██╔══██╗██║  ██║██╔══╝  ██╔══██╗╚════██║
 ╚██████╔╝██║  ██║██████╔╝███████╗██║  ██║███████║
  ╚═════╝ ╚═╝  ╚═╝╚═════╝ ╚══════╝╚═╝  ╚═╝╚══════╝
*/

/* Includes */
include_once 'Auth.php';
include_once 'Status.php';

class Order {

	static public function requestNewOrder($user_name, $user_password, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude) {
		$newOrderWithVehicle = Order::fetchOrderFromOrderServer($user_name, $user_password, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude, $userDate);
		echo $newOrderWithVehicle;
	}

	static public function fetchOrderFromOrderServer($user_name, $user_password, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude, $userDate)
	{
	    $isAuthenticated = Auth::verifyUserCredentials($user_name, $user_password, NULL);

	    if (!$isAuthenticated) {
	        Status::returnStatus("User not authenticated!");
	        return;
	    }
	    // Get cURL resource
	    $curl = curl_init();
		// Set some options - we are passing in a useragent too here
	    curl_setopt_array($curl, array(
	        CURLOPT_RETURNTRANSFER => 1,
	        CURLOPT_URL => 'https://salzaidy.create.stedwards.edu/cosc3339/createOrder.php',
	        CURLOPT_USERAGENT => 'ROBOTAXI_CLIENT_1.0',
	        CURLOPT_POST => 1,
	        CURLOPT_POSTFIELDS => array(
	            'user_name' 		=> $user_name,
	            'user_pass' 		=> $user_password,
				'user_longitude' 	=> $userLongitude,
				'user_latitude'		=> $userLatitude,
				'dest_long'			=> $destLongitude,
				'dest_lat'			=> $destLatitude,
				'date'				=> $userDate
	        )
	    ));

	    $jsonResp = curl_exec($curl);

	    curl_close($curl);
	    return $jsonResp;

	    //return json_decode($jsonResp, true); //'true' returns an array instead of a json object

	}

	static public function createDummyOrder($user_name, $user_password, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude) {

		//JSON Example

		$isAuthenticated = Auth::verifyUserCredentials($user_name, $user_password, NULL);

		if (!$isAuthenticated) {
			Status::returnStatus("User not authenticated!");
			return;
		}

		$nearestVehicle = Vehicle::getNearestAvailableVehicle($userLatitude, $userLongitude);

		$order = array(
			'user_id'  		=> (int)0,
			'order_id' 		=> rand(1, 999), //We'll fill these in soon
			'orderDate' 	=> $user_date,
			'start_lat' 	=> (float)$userLatitude,
			'start_long' 	=> (float)$userLongitude,
			'end_lat' 		=> (float)$destLatitude,
			'end_long' 		=> (float)$destLongitude,

			'vehicle' 		=> $nearestVehicle, //Array

			'status'		=> 'Success'

		);

		$myJSON = json_encode($order);

		echo $myJSON;

	}

}


?>
