<?php
/**
 * Created by IntelliJ IDEA.
 * User: guillermo
 * Date: 3/22/18
 * Time: 4:07 PM
 */

$userName  			= $_POST["user_name"];
$userPass 			= $_POST["user_pass"];

$userLocationLong 	= $_POST["user_longitude"];
$userLocationLat 	= $_POST["user_latitude"];
$destinationLong	= $_POST["dest_long"];
$destinationLat		= $_POST["dest_lat"];
$userDate			= $_POST["date"];

function main($userName, $userPass, $userLocationLong, $userLocationLat, $destinationLong, $destinationLat, $userDate)
{

    $isAuthenticated = authenticate($userName, $userPass, NULL);

    if (!$isAuthenticated) {
        returnStatus("User not authenticated!");
        return;
    }

    if (!isset($userLocationLong, $userLocationLat, $destinationLat, $destinationLong, $userDate)) {
        returnStatus("Parameters not set!1");
        return;
    }

    //$newOrder = createDummyOrder($userName, $userPass, $userDate, $userLocationLat, $userLocationLong, $destinationLat, $destinationLong);
    $newOrder = createNewOrder($userName, $userDate, $userLocationLat, $userLocationLong, $destinationLat, $destinationLong);
    echo $newOrder;
    return;
}

function authenticate($userName, $userPass) {
    /* Implement Mohammed's authentication later */
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
		return true;
	}
	else {
		return false;
	}

}

function createNewOrder($user_name, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude) {


    $vehicleInfo = getNearestAvailableVehicle($userLatitude, $userLongitude);

    include "./Order.php";
    $newOrder = new Order(0, 0, 1, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude);

    include "./orderRepository.php";

    orderRepository::insertOrder($newOrder);

    $order = array(
        'user_id'  		=> (int)$newOrder->getUserId(),
        'order_id' 		=> (int)$newOrder->getOrderId(), //We'll fill these in soon
        'orderDate' 	=> $user_date,
        'start_lat' 	=> (float)$newOrder->getStartLatitude(),
        'start_long' 	=> (float)$newOrder->getStartLongitude(),
        'end_lat' 		=> (float)$newOrder->getEndLatitude(),
        'end_long' 		=> (float)$newOrder->getEndLongitude(),

        'vehicle' 		=> $vehicleInfo, //Array

        'status'		=> 'Success'

    );

    $myJSON = json_encode($order);

    return $myJSON;

}

function createDummyOrder($user_name, $user_password, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude) {

    //JSON Example

    $isAuthenticated = authenticate($user_name, $user_password, NULL);

    if (!$isAuthenticated) {
        returnStatus("User not authenticated!");
        return;
    }

    $nearestVehicle = getNearestAvailableVehicle($userLatitude, $userLongitude);

    $order = array(
        'user_id'  		=> (int)$user_name,
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

    return $myJSON;

}

/*
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

 	return json_decode($jsonResp, true); //'true' returns an array instead of a json object

}

function getNearestAvailableVehicle($userLatitude, $userLongitude) {
	$curl = curl_init();

	$vehicle = getAvailableRandomVehicle();

	curl_setopt_array($curl, array(
	    CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => 'https://meicher.create.stedwards.edu/WeGoVehicleDB/getVehicle.php?vehicleID=' . $vehicle,
	    CURLOPT_USERAGENT => 'ROBOTAXI_CLIENT_1.0'
	));

	$jsonResp = curl_exec($curl);

	curl_close($curl);

	return json_decode($jsonResp, true); //'true' returns an array instead of a json object
}

function getAvailableRandomVehicle() {

	$availableVehicleIDs = array();

	for ($x = 1; $x < 1024; $x++) {

		$vehicle = returnUpdatedVehicleInfoArray($x, nil);
		if (is_null($vehicle)) {
			break;
		}
		if ($vehicle['inUse'] == 0) {
			array_push($availableVehicleIDs, $x);
		}

	}
	return $availableVehicleIDs[array_rand($availableVehicleIDs)];
}

function returnStatus($message) {
    $hype = new stdClass();
    $hype->status = $message;
    $myJSON = json_encode($hype);
    echo $myJSON;
}

main($userName, $userPass, $userLocationLong, $userLocationLat, $destinationLong, $destinationLat, $userDate);

?>
