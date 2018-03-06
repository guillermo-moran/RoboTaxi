<?php
/**
 * Created by IntelliJ IDEA.
 * User: Abo-norah91
 * Date: 2/26/18
 * Time: 11:39 PM
 */

  $mysqli = new mysqli("localhost", "malkhudc_user", "123456", "malkhudc_userdb");

 $result = $mysqli->query("SELECT * FROM user WHERE user_id = 1")->fetch_assoc();

// $rs = $mysqli->Execute("SELECT * FROM user WHERE user_id = 1" . reset($_GET));




$user = new stdClass();

$user -> user_id = $result['user_id']."<br>";

$user -> user_name = $result['user_name']."<br>";

$user -> user_firstName = $result['user_firstName']."<br>";

$user -> user_lastName = $result['user_lastName']."<br>";

$user -> Email = $result['Email']."<br>";

$user -> password = $result['password']."<br>";

$user -> credit_card_number = $result['credit_card_number']."<br>";

$user -> card_holder_name = $result['card_holder_name']."<br>";

$user -> credit_expiration = $result['credit_expiration']."<br>";

$user -> credit_ccv = $result['credit_ccv']."<br>";

$json = json_encode($user);
echo $json;




