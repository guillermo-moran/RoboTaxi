<?php

$userID  			= $_POST["user_id"];
$userPass 			= $_POST["user_pass"];
$userLocationLong 	= $_POST["user_longitude"];
$userLocationLat 	= $_POST["user_latitude"];
$destinationLong	= $_POST["dest_long"];
$destinationLat		= $_POST["dest_lat"];
$userDate			= $_POST["date"];

function createNewOrder($user_id, $user_password, $user_date, $userLatitude, $userLongitude, $destLatitude, $destLongitude) {

	//JSON Example
	$newOrder = new stdClass();
	if (verifyUserCredentials($user_id, $user_password)) {
		$newOrder->user_id = (int)$user_id;
		$newOrder->order_id = rand(1, 999); //We'll fill these in soon
		$newOrder->vehicle_id = (int)0; //We'll fill these in soon
		$newOrder->orderDate = $user_date;
		$newOrder->start_lat = (float)$userLatitude;
		$newOrder->start_long = (float)$userLongitude;
		$newOrder->end_lat = (float)$destLatitude;
		$newOrder->end_long = (float)$destLongitude;

		$myJSON = json_encode($newOrder);

		echo $myJSON;
	}
	else {
		$newOrder->status = "Failure";
		$myJSON = json_encode($newOrder);
		echo $myJSON;
	}
}

function verifyUserCredentials($user_id, $user_password) {
	/*
	In the future, we want to make sure that the user is authenticated before
	creating a new vehicle order.
	*/

	//This is a temporary placeholder.
	if ($user_id === "0" && $user_password === "password") {
		return true;
	}
	else {
		return false;
	}
}

createNewOrder($userID, $userPass, $userDate, $userLocationLat, $userLocationLong, $destinationLat, $destinationLong);

?>
