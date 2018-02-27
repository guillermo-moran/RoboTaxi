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

$rs = $db->Execute("select user_id, user_name, user_firstName, user_lastName, Email, Password, credit_card_number, card_holder_name, credit_expiration, credit_ccv from user where user_id = " . reset($_GET));

print "{ </br>";
print "\"user_id\": " . $rs->fields['user_id'] . ", </br>";
print "\"user_name\": " . $rs->fields['user_name'] . ", </br>";
print "\"user_firstName\": " . $rs->fields['user_firstName'] . ", </br>";
print "\"user_lastName\": " . $rs->fields['user_lastName'] . ", </br>";
print "\"Email\": " . $rs->fields['Email'] . ", </br>";
print "\"Password\": " . $rs->fields['Password'] . ", </br>";
print "\"credit_card_number\": " . $rs->fields['credit_card_number'] . ", </br>";
print "\"card_holder_name\": " . $rs->fields['card_holder_name'] . ", </br>";
print "\"credit_expiration\": " . $rs->fields['credit_expiration'] . ", </br>";
print "\"credit_ccv\": " . $rs->fields['credit_ccv'] . ", </br>";
print "} </br>";

?>