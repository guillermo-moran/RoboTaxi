<?php
/**
 * Created by IntelliJ IDEA.
 * User: Abo-norah91
 * Date: 3/20/18
 * Time: 5:49 PM
 */



$mysqli = new mysqli("localhost", "malkhudc_userdb", "123456", "malkhudc_user");


if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

// prepare an insert statmenet
$sql = "INSERT INTO user( user_name, user_firstName, user_lastName, email, password, credit_card_number, card_holder_name, credit_expiration, credit_ccv) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";

if($stmt = $mysqli->prepare($sql)){
    // Bind variable to the prepared statement as parameters
    $stmt->bind_param("ssssiisii", $user_name, $user_firstName, $user_lastName, $email, $password, $credit_card_number, $card_holder_name, $credit_expiration, $credit_ccv );

    //set parameters
    $user_name = $_REQUEST['user_name'];
    $user_firstName = $_REQUEST['user_firstName'];
    $user_lastName = $_REQUEST['user_lastName'];
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $credit_card_number = $_REQUEST['credit_card_number'];
    $card_holder_name = $_REQUEST['card_holder_name'];
    $credit_expiration = $_REQUEST['credit_expiration'];
    $credit_ccv = $_REQUEST['credit_ccv'];

    //Attempt tp excute the prepared statement
    if($stmt-> execute()){
        echo "Record inserted successfully.";

    } else{
        echo "ERROER: Could not execute query: $sql. " . $mysqli->error;
    }
} else {
    echo "ERROER: Could not prepare query: $sql. " . $mysqli->error;
}
// close statment
$stmt->close();



$mysqli -> close();
