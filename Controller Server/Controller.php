<?php

$userName  			= $_POST["user_name"];
$userPass 			= $_POST["user_pass"];

$userLocationLong 	= $_POST["user_longitude"];
$userLocationLat 	= $_POST["user_latitude"];
$destinationLong	= $_POST["dest_long"];
$destinationLat		= $_POST["dest_lat"];
$userDate			= $_POST["date"];

$vehicleID			= $_POST["vehicleID"];
$routeCoordinates 	= $_POST["route_coordinates"];

$requestType 		= $_POST["request_type"];

/*
	=======================
	VALID REQUEST TYPES
	=======================

	ORDER 			- Submit a vehicle and trip order
	AUTHENTICATE 	- Request server authentication
	PING			- Ping the server
	UPDATE_VEHICLE	- Update vehicle location
	VEHICLE_LIST	- List of all nearby vehicles
	ROUTE_VEHICLE	- Begin vehicle route simulation
	

*/


/*
 ███╗   ███╗ █████╗ ██╗███╗   ██╗
 ████╗ ████║██╔══██╗██║████╗  ██║
 ██╔████╔██║███████║██║██╔██╗ ██║
 ██║╚██╔╝██║██╔══██║██║██║╚██╗██║
 ██║ ╚═╝ ██║██║  ██║██║██║ ╚████║
 ╚═╝     ╚═╝╚═╝  ╚═╝╚═╝╚═╝  ╚═══╝
*/

function main($userName, $userPass, $userLocationLong, $userLocationLat, $destinationLong, $destinationLat, $userDate, $requestType, $vehicleID, $routeCoordinates) {

	if (isset($requestType)) {

		if ($requestType === "ORDER") {

			if (!isset($userName, $userPass, $userLocationLong, $userLocationLat, $destinationLat, $destinationLong, $userDate)) {
				returnStatus("Parameters not set!");
				return;
			}

            requestNewOrder($userName, $userPass, $userDate, $userLocationLat, $userLocationLong, $destinationLat, $destinationLong, $userDate);
			return;
		}
		if ($requestType === "AUTHENTICATE") {


			if (!isset($userName, $userPass)) {
				returnStatus("Parameters not set!");
				return;
			}


			verifyUserCredentials($userName, $userPass, $requestType);
			return;
		}

		if ($requestType === "VEHICLE_LIST") {
			if (!isset($userLocationLat, $userLocationLong)) {
				returnStatus("Parameters not set!");
				return;
			}
			getAllNearbyVehicles($userLocationLat, $userLocationLong);
			return;
		}

		if ($requestType === "PING") {
			returnStatus("PONG");
			return;
		}
		if ($requestType == "UPDATE_VEHICLE") {
			returnUpdatedVehicleInfoArray($vehicleID);
			return;
		}

		if ($requestType == "ROUTE_VEHICLE") {
			beginVehicleRouteSimulation($vehicleID, $routeCoordinates);
			return;
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

function requestNewOrder($user_name, $user_password, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude) {
	$newOrderWithVehicle = fetchOrderFromOrderServer($user_name, $user_password, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude);
	echo $newOrderWithVehicle;
}

function fetchOrderFromOrderServer($user_name, $user_password, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude, $userDate)
{
    $isAuthenticated = verifyUserCredentials($user_name, $user_password, NULL);

    if (!$isAuthenticated) {
        returnStatus("User not authenticated!");
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

function createDummyOrder($user_name, $user_password, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude) {

	//JSON Example

	$isAuthenticated = verifyUserCredentials($user_name, $user_password, NULL);

	if (!$isAuthenticated) {
		returnStatus("User not authenticated!");
		return;
	}

	$nearestVehicle = getNearestAvailableVehicle($userLatitude, $userLongitude);

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

/*
 ██╗   ██╗███████╗██╗  ██╗██╗ ██████╗██╗     ███████╗███████╗
 ██║   ██║██╔════╝██║  ██║██║██╔════╝██║     ██╔════╝██╔════╝
 ██║   ██║█████╗  ███████║██║██║     ██║     █████╗  ███████╗
 ╚██╗ ██╔╝██╔══╝  ██╔══██║██║██║     ██║     ██╔══╝  ╚════██║
  ╚████╔╝ ███████╗██║  ██║██║╚██████╗███████╗███████╗███████║
   ╚═══╝  ╚══════╝╚═╝  ╚═╝╚═╝ ╚═════╝╚══════╝╚══════╝╚══════╝
 */

function returnUpdatedVehicleInfoArray($vehicleID) {

	$curl = curl_init();

 	curl_setopt_array($curl, array(
 	    CURLOPT_RETURNTRANSFER => 1,
 	    CURLOPT_URL => 'https://meicher.create.stedwards.edu/WeGoVehicleDB/getVehicle.php?vehicleID='.$vehicleID,
 	    CURLOPT_USERAGENT => 'ROBOTAXI_CLIENT_1.0'
 	));

 	$jsonResp = curl_exec($curl);

 	curl_close($curl);

 	return json_decode($jsonResp, true); //'true' returns an array instead of a json object

}

function getAllNearbyVehicles($userLatitude, $userLongitude) {

	$vehiclesArray = array();

	for ($x = 1; $x < 1024; $x++) {

		$vehicle = returnUpdatedVehicleInfoArray($x);
		if (is_null($vehicle)) {
			break;
		}
		$vehiclesArray[$x] = $vehicle;
	}

	$myJSON = json_encode($vehiclesArray);
	echo $myJSON;


	/*
	$curl = curl_init();

 	curl_setopt_array($curl, array(
 	    CURLOPT_RETURNTRANSFER => 1,
 	    CURLOPT_URL => 'https://meicher.create.stedwards.edu/WeGoVehicleDB/getAllVehicles.php',
 	    CURLOPT_USERAGENT => 'ROBOTAXI_CLIENT_1.0'
 	));

 	$jsonResp = curl_exec($curl);

 	curl_close($curl);
	//echo $jsonResp;

	*/



 	//echo json_decode($jsonResp, false); //'true' returns an array instead of a json object

}

function beginVehicleRouteSimulation($vehicleID, $routeString) {
	$command = escapeshellcmd('./Sim/VehicleSim.py 5 5 5');
	$output = shell_exec($command);
	echo $output;
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

	/*
    // Get cURL resource
    $curl = curl_init();
    // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://malkhud2.create.stedwards.edu/user/authenticate.php',
        CURLOPT_USERAGENT => 'ROBOTAXI_CLIENT_1.0',
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => array(
            'username' 		=> $user_name,
            'password' 		=> $user_password
        )
    ));

    $jsonResp = curl_exec($curl);

    curl_close($curl);

    $array = json_decode($jsonResp, true); //'true' returns an array instead of a json object

	if ($array['status'] === "success") {
		return true;
	}
	else {
		return false;
	}
	*/

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

main($userName, $userPass, $userLocationLong, $userLocationLat, $destinationLong, $destinationLat, $userDate, $requestType, $vehicleID, $routeCoordinates);
//beginVehicleRouteSimulation(1,1);
//getAllNearbyVehicles(2,2);
?>
