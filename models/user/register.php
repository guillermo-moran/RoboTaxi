<?php
/**
 * Created by .
 * User: mohammed Alkhudhayr
 * Date: 03/023/18
 * Time: 1:50 PM
 */

//importing required script
// require_once '../includes/DbOperation.php';

require_once __DIR__ . "/DbOperation.php";
//require_once __DIR__ . "/makeUser.php";

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!verifyRequiredParams(array('user_name', 'user_firstName', 'user_lastName', 'email', 'password', 'credit_card_number', 'card_holder_name', 'credit_expiration', 'credit_ccv'))) {
        //getting values
        $user_name = $_REQUEST['user_name'];
        $user_firstName = $_REQUEST['user_firstName'];
        $user_lastName = $_REQUEST['user_lastName'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $credit_card_number = $_REQUEST['credit_card_number'];
        $card_holder_name = $_REQUEST['card_holder_name'];
        $credit_expiration = $_REQUEST['credit_expiration'];
        $credit_ccv = $_REQUEST['credit_ccv'];


        //creating db operation object
        $db = new DbOperation();

        //adding user to database
        $result = $db->createUser($user_name, $user_firstName, $user_lastName, $email, $password, $credit_card_number, $card_holder_name, $credit_expiration, $credit_ccv);

        //making the response accordingly
        if ($result == USER_CREATED) {
            $response['error'] = false;
            $response['message'] = 'User created successfully';
        } elseif ($result == USER_ALREADY_EXIST) {
            $response['error'] = true;
            $response['message'] = 'User already exist';
        } elseif ($result == USER_NOT_CREATED) {
            $response['error'] = true;
            $response['message'] = 'Some error occurred';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'Required parameters are missing';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Invalid request';
}

//function to validate the required parameter in request
function verifyRequiredParams($required_fields)
{

    //Getting the request parameters
    $request_params = $_REQUEST;

    //Looping through all the parameters
    foreach ($required_fields as $field) {
        //if any requred parameter is missing
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {

            //returning true;
            return true;
        }
    }
    return false;
}

echo json_encode($response);

?>