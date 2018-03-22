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

function main($userName, $userPass, $userLocationLong, $userLocationLat, $destinationLong, $destinationLat, $userDate, $requestType)
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

    $newOrder = createDummyOrder($userName, $userDate, $userLocationLat, $userLocationLong, $destinationLat, $destinationLong);
    return;
}

function authenticate($userName, $userPass) {
    /* Implement Mohammed's authentication later */
    return true;
}

function createDummyOrder($user_name, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude) {

    //JSON Example

    $isAuthenticated = verifyUserCredentials($user_name, $user_password, NULL);

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


function getNearestAvailableVehicle($userLatitude, $userLongitude) {

    /*
    We'll return vehicle id 1 from Marcus' server for now :)
    */

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

function returnStatus($message) {
    $hype = new stdClass();
    $hype->status = $message;
    $myJSON = json_encode($hype);
    echo $myJSON;
}

main($userName, $userPass, $userLocationLong, $userLocationLat, $destinationLong, $destinationLat, $userDate, $requestType);

?>

main($userName, $userPass, $userLocationLong, $userLocationLat, $destinationLong, $destinationLat, $userDate, $requestType);


?>