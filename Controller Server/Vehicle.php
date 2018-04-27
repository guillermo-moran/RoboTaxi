<?php

/*
 ██╗   ██╗███████╗██╗  ██╗██╗ ██████╗██╗     ███████╗███████╗
 ██║   ██║██╔════╝██║  ██║██║██╔════╝██║     ██╔════╝██╔════╝
 ██║   ██║█████╗  ███████║██║██║     ██║     █████╗  ███████╗
 ╚██╗ ██╔╝██╔══╝  ██╔══██║██║██║     ██║     ██╔══╝  ╚════██║
  ╚████╔╝ ███████╗██║  ██║██║╚██████╗███████╗███████╗███████║
   ╚═══╝  ╚══════╝╚═╝  ╚═╝╚═╝ ╚═════╝╚══════╝╚══════╝╚══════╝
 */

 class Vehicle {

	 static public function returnUpdatedVehicleInfoArray($vehicleID, $requestType) {

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

	 static public function getAvailableRandomVehicle() {

	 	$availableVehicleIDs = array();

	 	for ($x = 1; $x < 1024; $x++) {

	 		$vehicle = Vehicle::returnUpdatedVehicleInfoArray($x, nil);
	 		if (is_null($vehicle)) {
	 			break;
	 		}
	 		if ($vehicle['inUse'] == 0) {
	 			array_push($availableVehicleIDs, $x);
	 		}

	 	}
	 	return $availableVehicleIDs[array_rand($availableVehicleIDs)];
	 }



	 static public function getAllNearbyVehicles($userLatitude, $userLongitude) {

	 	$vehiclesArray = array();

	 	for ($x = 1; $x < 1024; $x++) {

	 		$vehicle = Vehicle::returnUpdatedVehicleInfoArray($x, nil);
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

	 static public function beginVehicleRouteSimulation($vehicleID, $routeString) {
	 	$cmd = './Sim/VehicleSim.py' . " " . $vehicleID . " " . $routeString;
	 	$command = escapeshellcmd($cmd);
	 	//echo $command;
	 	$output = shell_exec($command);

	 	if (strpos($output, 'SUCCESS') !== false) {
	     	Status::returnStatus("Success");
	 	}
	 }

	 static public function getNearestAvailableVehicle($userLatitude, $userLongitude) {
	 	$curl = curl_init();

	 	$vehicle = Vehicle::getAvailableRandomVehicle();

	 	curl_setopt_array($curl, array(
	 	    CURLOPT_RETURNTRANSFER => 1,
	 	    CURLOPT_URL => 'https://meicher.create.stedwards.edu/WeGoVehicleDB/getVehicle.php?vehicleID=' . $vehicle,
	 	    CURLOPT_USERAGENT => 'ROBOTAXI_CLIENT_1.0'
	 	));

	 	$jsonResp = curl_exec($curl);

	 	curl_close($curl);

	 	return json_decode($jsonResp, true); //'true' returns an array instead of a json object
	 }

 }


?>
