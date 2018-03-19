<?php

$userName  			= $_POST["user_name"];
$userPass 			= $_POST["user_pass"];

$userLocationLong 	= $_POST["user_longitude"];
$userLocationLat 	= $_POST["user_latitude"];
$destinationLong	= $_POST["dest_long"];
$destinationLat		= $_POST["dest_lat"];
$userDate			= $_POST["date"];

$vehicleID			= $_POST["vehicleID"];

$requestType 		= $_POST["request_type"];

/*
	=======================
	VALID REQUEST TYPES
	=======================

	ORDER 			- Submit a vehicle and trip order
	AUTHENTICATE 	- Request server authentication
	PING			- Ping the server
	UPDATE_VEHICLE	- Update vehicle location

*/


/*
 ███╗   ███╗ █████╗ ██╗███╗   ██╗
 ████╗ ████║██╔══██╗██║████╗  ██║
 ██╔████╔██║███████║██║██╔██╗ ██║
 ██║╚██╔╝██║██╔══██║██║██║╚██╗██║
 ██║ ╚═╝ ██║██║  ██║██║██║ ╚████║
 ╚═╝     ╚═╝╚═╝  ╚═╝╚═╝╚═╝  ╚═══╝
*/

function main($userName, $userPass, $userLocationLong, $userLocationLat, $destinationLong, $destinationLat, $userDate, $requestType) {

	if (isset($requestType)) {

		if ($requestType === "ORDER") {

			if (!isset($userName, $userPass, $userLocationLong, $userLocationLat, $destinationLat, $destinationLong, $userDate)) {
				returnStatus("Parameters not set!1");
				return;
			}

			createNewOrder($userName, $userPass, $userDate, $userLocationLat, $userLocationLong, $destinationLat, $destinationLong);
			return;
		}
		if ($requestType === "AUTHENTICATE") {


			if (!isset($userName, $userPass)) {
				returnStatus("Parameters not set!2");
				return;
			}


			verifyUserCredentials($userName, $userPass, $requestType);
			return;
		}

		if ($requestType === "PING") {
			returnStatus("PONG");
		}

		returnStatus("Invalid request type");
	}
	else {
		returnStatus("Invalid request type");
	}

}

/*
  ██████╗ ██████╗ ██████╗ ███████╗██████╗ ███████╗
 ██╔═══██╗██╔══██╗██╔══██╗██╔════╝██╔══██╗██╔════╝
 ██║   ██║██████╔╝██║  ██║█████╗  ██████╔╝███████╗
 ██║   ██║██╔══██╗██║  ██║██╔══╝  ██╔══██╗╚════██║
 ╚██████╔╝██║  ██║██████╔╝███████╗██║  ██║███████║
  ╚═════╝ ╚═╝  ╚═╝╚═════╝ ╚══════╝╚═╝  ╚═╝╚══════╝
*/

function createNewOrder($user_name, $user_password, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude) {

	//JSON Example

	$isAuthenticated = verifyUserCredentials($user_name, $user_password, NULL);

	if (!$isAuthenticated) {
		returnStatus("User not authenticated!");
		return;
	}

	$nearestVehicle = getNearestAvailableVehicle($userLatitude, $userLongitude);

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

/*
 ██╗   ██╗███████╗██╗  ██╗██╗ ██████╗██╗     ███████╗███████╗
 ██║   ██║██╔════╝██║  ██║██║██╔════╝██║     ██╔════╝██╔════╝
 ██║   ██║█████╗  ███████║██║██║     ██║     █████╗  ███████╗
 ╚██╗ ██╔╝██╔══╝  ██╔══██║██║██║     ██║     ██╔══╝  ╚════██║
  ╚████╔╝ ███████╗██║  ██║██║╚██████╗███████╗███████╗███████║
   ╚═══╝  ╚══════╝╚═╝  ╚═╝╚═╝ ╚═════╝╚══════╝╚══════╝╚══════╝
 */

function getVehicleLocation($vehicleID) {

	$curl = curl_init();

 	curl_setopt_array($curl, array(
 	    CURLOPT_RETURNTRANSFER => 1,
 	    CURLOPT_URL => 'https://meicher.create.stedwards.edu/WeGoVehicleDB/getVehicle.php?vehicleID=$vehicleID',
 	    CURLOPT_USERAGENT => 'ROBOTAXI_CLIENT_1.0'
 	));

 	$jsonResp = curl_exec($curl);

 	curl_close($curl);

 	return json_decode($jsonResp, true); //'true' returns an array instead of a json object

}

function getAllNearbyVehicles($userLatitude, $userLongitude) {

}

function getNearestAvailableVehicle($userLatitude, $userLongitude) {
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

/*
  █████╗ ██╗   ██╗████████╗██╗  ██╗
 ██╔══██╗██║   ██║╚══██╔══╝██║  ██║
 ███████║██║   ██║   ██║   ███████║
 ██╔══██║██║   ██║   ██║   ██╔══██║
 ██║  ██║╚██████╔╝   ██║   ██║  ██║
 ╚═╝  ╚═╝ ╚═════╝    ╚═╝   ╚═╝  ╚═╝
*/

function verifyUserCredentials($user_name, $user_password, $requestType) {
	/*
	In the future, we want to make sure that the user is authenticated before
	creating a new vehicle order.
	*/

	//This is a temporary placeholder.
	if ($user_name === "user" && $user_password === "password") {
		if ($requestType === "AUTHENTICATE") {
			returnStatus("Authenticated");
		}
		return true;
	}
	else {
		if ($requestType === "AUTHENTICATE") {
			returnStatus("Authentication Failure");
		}
		return false;
	}
}

/*
 ███╗   ███╗██╗███████╗ ██████╗
 ████╗ ████║██║██╔════╝██╔════╝
 ██╔████╔██║██║███████╗██║
 ██║╚██╔╝██║██║╚════██║██║
 ██║ ╚═╝ ██║██║███████║╚██████╗
 ╚═╝     ╚═╝╚═╝╚══════╝ ╚═════╝
*/

function returnStatus($message) {
	$hype = new stdClass();
	$hype->status = $message;
	$myJSON = json_encode($hype);
	echo $myJSON;
}

main($userName, $userPass, $userLocationLong, $userLocationLat, $destinationLong, $destinationLat, $userDate, $requestType);

?>
