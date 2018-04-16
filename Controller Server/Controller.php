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
	UPDATE_VEHICLE	- Return updated vehicle information
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

	$isAuthenticated = verifyUserCredentials($user_name, $user_password, NULL);

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
			if (!isset($vehicleID)) {
				returnStatus("Parameters not set!");
				return;
			}
			returnUpdatedVehicleInfoArray($vehicleID, $requestType);
			return;
		}

		if ($requestType == "ROUTE_VEHICLE") {
			if (!isset($vehicleID, $routeCoordinates)) {
				returnStatus("Parameters not set!");
				return;
			}
			beginVehicleRouteSimulation($vehicleID, $routeCoordinates);
			returnStatus("Success");
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
	$newOrderWithVehicle = fetchOrderFromOrderServer($user_name, $user_password, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude, $userDate);
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

function returnUpdatedVehicleInfoArray($vehicleID, $requestType) {

	$curl = curl_init();

 	curl_setopt_array($curl, array(
 	    CURLOPT_RETURNTRANSFER => 1,
 	    CURLOPT_URL => 'https://meicher.create.stedwards.edu/WeGoVehicleDB/getVehicle.php?vehicleID='.$vehicleID,
 	    CURLOPT_USERAGENT => 'ROBOTAXI_CLIENT_1.0'
 	));

 	$jsonResp = curl_exec($curl);

 	curl_close($curl);

	if ($requestType == 'UPDATE_VEHICLE') {
		echo $jsonResp;
	}

 	return json_decode($jsonResp, true); //'true' returns an array instead of a json object

}

function getAllNearbyVehicles($userLatitude, $userLongitude) {

	$vehiclesArray = array();

	for ($x = 1; $x < 1024; $x++) {

		$vehicle = returnUpdatedVehicleInfoArray($x, nil);
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
	$cmd = './Sim/VehicleSim.py' . " " . $vehicleID . " " . $routeString;
	$command = escapeshellcmd($cmd);
	//echo $command;
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
//beginVehicleRouteSimulation("1","30.2281019836664 -97.7541680489094 30.2279329206795 -97.7537740156412 30.22785496898 -97.7535960678369 30.2278309967369 -97.7535410825521 30.2277489379048 -97.753583075887 30.2271089795977 -97.7539240517081 30.2267819177359 -97.754085068068 30.2267329674214 -97.7541100461395 30.2269639726728 -97.7545970347139 30.2272349596023 -97.7551540121797 30.2276449184865 -97.755934032089 30.2283819392324 -97.7574690100172 30.2289569377899 -97.7587390359861 30.2293109893799 -97.7595730353518 30.2295449282974 -97.7600640472397 30.2295899391174 -97.7601540688798 30.2296319324523 -97.7602360438928 30.2303219307214 -97.7598020289465 30.2324779238552 -97.7584680490565 30.2341729961336 -97.7573950816312 30.2345649339259 -97.7571150422462 30.235529942438 -97.7563610062367 30.2371899783611 -97.7549290418985 30.2388159837574 -97.7535770409167 30.2390979509801 -97.7533080656439 30.239488966763 -97.7529960073887 30.2396469656378 -97.7529170498608 30.2399239875376 -97.7528360806762 30.2418789826334 -97.7525280457345 30.2425799611956 -97.7522930171695 30.2454199176282 -97.7512280125523");
//getAllNearbyVehicles(2,2);
//returnUpdatedVehicleInfoArray(1);
?>
