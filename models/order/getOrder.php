<?php
/**
 * Created by IntelliJ IDEA.
 * User: salzaidy
 * Date: 2/26/18
 * Time: 11:39 PM
 */




$mysqli = new mysqli("localhost", "salzaidy_order", "12345", "salzaidy_cosc3339");

$result = $mysqli->query("SELECT * FROM orderdb WHERE userId = 1")->fetch_assoc();




$order = new stdClass();

$order -> orderId = $result['orderId']."<br>";

$order -> userId = $result['userId']."<br>";

$order -> userName = $result['userName']."<br>";

$order -> vehicelId = $result['vehicelId']."<br>";

$order -> orderDate = $result['orderDate']."<br>";

$order -> startLatitude = $result['startLatitude']."<br>";

$order -> startLongitude = $result['startLongitude']."<br>";

$order -> endLatitude = $result['endLatitude']."<br>";

$order -> endLongitude = $result['endLongitude']."<br>";

$order -> amount = $result['amount']."<br>";

$json = json_encode($order);
echo $json;




?>
