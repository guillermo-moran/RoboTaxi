<?php
/**
 * Created by IntelliJ IDEA.
 * User: Abo-norah91
 * Date: 2/26/18
 * Time: 11:39 PM
 */

include('../adodb519/adodb5/adodb.inc.php');

$db = ADONewConnection('mysql');
$db->PConnect('localhost','malkhudc_userdb','123456','malkhudc_user');

$rs = $db->Execute("SELECT * FROM user WHERE user_id = 1" . reset($_GET));


// select user_id, user_name, user_firstName, user_lastName, Email, password, credit_card_number, card_holder_name, credit_expiration, credit_ccv from user where user_id = "

$user = new stdClass();

$user -> user_id                =$rs->fields['user_id']."<br>";

$user -> user_name              = $rs->fields['user_name']."<br>";
$user -> user_firstName         = $rs->fields['user_firstName']."<br>";
$user -> user_lastName          = $rs->fields['user_lastName']."<br>";
$user -> Email                  = $rs->fields['Email']."<br>";
$user -> password               = $rs->fields['password']."<br>";
$user -> credit_card_number     = $rs->fields['credit_card_number']."<br>";
$user -> card_holder_name       = $rs->fields['card_holder_name']."<br>";
$user -> credit_expiration      = $rs->fields['credit_expiration']."<br>";
$user -> credit_ccv             = $rs->fields['credit_ccv']."<br>";

$json = json_encode($user);
echo $json;





?>