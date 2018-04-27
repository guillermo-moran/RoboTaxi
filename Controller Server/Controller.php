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
Includes
*/

include_once 'Auth.php';
include_once 'Order.php';
include_once 'Status.php';
include_once 'Vehicle.php';

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

	$isAuthenticated = Auth::verifyUserCredentials($user_name, $user_password, NULL);

	//Request type is always required
	if (isset($requestType)) {

		// Request a new order
		if ($requestType === "ORDER") {

			if (!isset($userName, $userPass, $userLocationLong, $userLocationLat, $destinationLat, $destinationLong, $userDate)) {
				Status::returnStatus("Parameters not set!");
				return;
			}

            Order::requestNewOrder($userName, $userPass, $userDate, $userLocationLat, $userLocationLong, $destinationLat, $destinationLong, $userDate);
			return;
		}

		//Request authentication
		if ($requestType === "AUTHENTICATE") {

			if (!isset($userName, $userPass)) {
				Status::returnStatus("Parameters not set!");
				return;
			}
			Auth::verifyUserCredentials($userName, $userPass, $requestType);
			return;
		}

		//Request list of nearby vehicles
		if ($requestType === "VEHICLE_LIST") {
			if (!isset($userLocationLat, $userLocationLong)) {
				Status::returnStatus("Parameters not set!");
				return;
			}
			Vehicle::getAllNearbyVehicles($userLocationLat, $userLocationLong);
			return;
		}

		//Request ping
		if ($requestType === "PING") {
			Status::returnStatus("PONG");
			return;
		}

		//Request new vehicle info
		if ($requestType == "UPDATE_VEHICLE") {
			if (!isset($vehicleID)) {
				Status::returnStatus("Parameters not set!");
				return;
			}
			Vehicle::returnUpdatedVehicleInfoArray($vehicleID, $requestType);
			return;
		}

		//Begin vehicle routing
		if ($requestType == "ROUTE_VEHICLE") {
			if (!isset($vehicleID, $routeCoordinates)) {
				Status::returnStatus("Parameters not set!");
				return;
			}
			Vehicle::beginVehicleRouteSimulation($vehicleID, $routeCoordinates);
			return;
		}


		Status::returnStatus("Invalid request type");

	}
	else {
		Status::returnStatus("Invalid request type");
	}

}



main($userName, $userPass, $userLocationLong, $userLocationLat, $destinationLong, $destinationLat, $userDate, $requestType, $vehicleID, $routeCoordinates);
//beginVehicleRouteSimulation("1","30.2281019836664 -97.7541680489094 30.2279329206795 -97.7537740156412 30.22785496898 -97.7535960678369 30.2278309967369 -97.7535410825521 30.2277489379048 -97.753583075887 30.2271089795977 -97.7539240517081 30.2267819177359 -97.754085068068 30.2267329674214 -97.7541100461395 30.2269639726728 -97.7545970347139 30.2272349596023 -97.7551540121797 30.2276449184865 -97.755934032089 30.2283819392324 -97.7574690100172 30.2289569377899 -97.7587390359861 30.2293109893799 -97.7595730353518 30.2295449282974 -97.7600640472397 30.2295899391174 -97.7601540688798 30.2296319324523 -97.7602360438928 30.2303219307214 -97.7598020289465 30.2324779238552 -97.7584680490565 30.2341729961336 -97.7573950816312 30.2345649339259 -97.7571150422462 30.235529942438 -97.7563610062367 30.2371899783611 -97.7549290418985 30.2388159837574 -97.7535770409167 30.2390979509801 -97.7533080656439 30.239488966763 -97.7529960073887 30.2396469656378 -97.7529170498608 30.2399239875376 -97.7528360806762 30.2418789826334 -97.7525280457345 30.2425799611956 -97.7522930171695 30.2454199176282 -97.7512280125523");
//echo json_encode(getNearestAvailableVehicle(1,0));
//returnUpdatedVehicleInfoArray(1);

?>
