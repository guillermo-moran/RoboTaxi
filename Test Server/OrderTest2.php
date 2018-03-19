<?php

$userName  			= $_POST["user_name"];
$userPass 			= $_POST["user_pass"];
$userLocationLong 	= $_POST["user_longitude"];
$userLocationLat 	= $_POST["user_latitude"];
$destinationLong	= $_POST["dest_long"];
$destinationLat		= $_POST["dest_lat"];
$userDate			= $_POST["date"];



function createNewOrder($user_name, $user_password, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude) {

	//JSON Example
	$newOrder = new stdClass();
	$isAuthenticated = verifyUserCredentials($user_name, $user_password);

	if (!$isAuthenticated) {
		$newOrder->status = "Failure";
		$myJSON = json_encode($newOrder);
		echo $myJSON;
		return;
	}

	$nearestVehicle = getNearestVehicle($userLatitude, $userLongitude);

	$order = array(
		'user_id'  		=> (int)$user_id,
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

function getNearestVehicle($userLatitude, $userLongitude) {
	$curl = curl_init();

	curl_setopt_array($curl, array(
	    CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => 'https://meicher.create.stedwards.edu/WeGoVehicleDB/getVehicle.php?vehicleID=1',
	    CURLOPT_USERAGENT => 'ROBOTAXI_CLIENT_1.0'
	));

	$jsonResp = curl_exec($curl);

	curl_close($curl);

	return json_decode($jsonResp, true); //'true' returns an array instead of a json object
}

function verifyUserCredentials($user_name, $user_password) {
	/*
	In the future, we want to make sure that the user is authenticated before
	creating a new vehicle order.
	*/

	//This is a temporary placeholder.
	if ($user_name === "user" && $user_password === "password") {
		return true;
	}
	else {
		return false;
	}
}

createNewOrder($userName, $userPass, $userDate, $userLocationLat, $userLocationLong, $destinationLat, $destinationLong);

?>
