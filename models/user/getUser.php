<?php
/**
 * Created by IntelliJ IDEA.
 * User: Abo-norah91
 * Date: 2/26/18
 * Time: 11:39 PM
 */


$mysqli = new mysqli("localhost", "malkhudc_userdb", "123456", "malkhudc_user");

$result = $mysqli->query("SELECT * FROM user WHERE user_id = ". $_GET['user_id'] )-> fetch_assoc();

// $rs = $mysqli->Execute("SELECT * FROM user WHERE user_id = 1" . reset($_GET));




$user = new stdClass();

$user -> user_id                    = $result['user_id'];

$user -> user_name                  = $result['user_name'];

$user -> user_firstName             = $result['user_firstName'];

$user -> user_lastName              = $result['user_lastName'];

$user -> Email                      = $result['email'];

$user -> password                   = $result['password'];

$user -> credit_card_number         = $result['credit_card_number'];

$user -> card_holder_name           = $result['card_holder_name'];

$user -> credit_expiration          = $result['credit_expiration'];

$user -> credit_ccv                 = $result['credit_ccv'];

$json = json_encode($user);


if ($user -> user_id == null)
{
    http_response_code(404);
    print "ERROR: user_id not in database!";
}
// else http_response_code(202);

else
{
    http_response_code(202);
    print $json;
}

$mysqli -> close();


