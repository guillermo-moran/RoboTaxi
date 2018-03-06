<?php
/**
 * Created by IntelliJ IDEA.
 * User: Mohammed Alkhudhayr
 * Date: 2/24/18
 * Time: 9:57 PM
 */


##The Response library makes it very easy to encapsulate data in a tertiary structure to build the json string more easily
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/userRepository.php";

$response = new Response();
$method = filter_var($_SERVER['REQUEST_METHOD'], FILTER_SANITIZE_STRING);

switch ($method) {
    case 'GET':
        if (isset($_GET['user_id'])) {
            $user_id = filter_var($_GET['user_id'], FILTER_SANITIZE_STRING);
            $user = userRepository::getUserById($user_id);
            $response->pushData($user);
            http_response_code(200);
            $response->echoJSONString();
        } else {
            foreach (userRepository::getAllUsers() as $user) {
                $response->pushData($user);
            }
            http_response_code(200);
            $response->echoJSONString();
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        if (!isset($data['user_id'])) {
            $response->pushError("(user_id) was not set for $method!");
        }
        if (!isset($data['userName'])) {
            $response->pushError("(userName) was not set for $method!");
        }
        if (!isset($data['userFirstName'])) {
            $response->pushError("(userFirstName) was not set for $method!");
        }
        if (!isset($data['userLastName'])) {
            $response->pushError("(userLastName) was not set for $method!");
        }
        if (!isset($data['userEmail'])) {
            $response->pushError("(userEmail) was not set for $method!");
        }
        if (!isset($data['userPassword'])) {
            $response->pushError("(userPassword) was not set for $method!");
        }
        if (!isset($data['creditCardNumber'])) {
            $response->pushError("(creditCardNumber) was not set for $method!");
        }
        if (!isset($data['cardHolderName'])) {
            $response->pushError("(cardHolderName) was not set for $method!");
        }
        if (!isset($data['cardExperationDate'])) {
            $response->pushError("(cardExperationDate) was not set for $method!");
        }
        if (!isset($data['ccv'])) {
            $response->pushError("(ccv) was not set for $method!");
        }
        if (!$response->getErrorCount()) {
            $user = new User($data['user_id'], $data['userName'], $data['userFirstName'], $data['userLastName'], $data['userEmail'], $data['userPassword'], $data['creditCardNumber'], $data['cardHolderName'], $data['cardExperationDate'], $data['ccv']);
            $querySuccess = userRepository::updateUser($user);
            if ($querySuccess) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        } else {
            http_response_code(400);
        }
        $response->echoJSONString();
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        if (!isset($data['userName'])) {
            $response->pushError("(userName) was not set for $method!");
        }
        if (!isset($data['userFirstName'])) {
            $response->pushError("(userFirstName) was not set for $method!");
        }
        if (!isset($data['userLastName'])) {
            $response->pushError("(userLastName) was not set for $method!");
        }
        if (!isset($data['userEmail'])) {
            $response->pushError("(userEmail) was not set for $method!");
        }
        if (!isset($data['userPassword'])) {
            $response->pushError("(userPassword) was not set for $method!");
        }
        if (!isset($data['creditCardNumber'])) {
            $response->pushError("(creditCardNumber) was not set for $method!");
        }
        if (!isset($data['cardHolderName'])) {
            $response->pushError("(cardHolderName) was not set for $method!");
        }
        if (!isset($data['cardExperationDate'])) {
            $response->pushError("(cardExperationDate) was not set for $method!");
        }
        if (!isset($data['ccv'])) {
            $response->pushError("(ccv) was not set for $method!");
        }
        if (!$response->getErrorCount()) {
            $user = new User(-1, $data['userName'], $data['userFirstName'], $data['userLastName'], $data['userEmail'], $data['userPassword'], $data['creditCardNumber'], $data['cardHolderName'], $data['cardExperationDate'], $data['ccv']);
            $querySuccess = userRepository::insertUser($user);
            if ($querySuccess) {
                http_response_code(200);
                $response->pushData(['user_id' => Database::getLastKey()]);
            } else {
                http_response_code(400);
            }
        } else {
            http_response_code(400);
        }
        $response->echoJSONString();
        break;
    case 'DELETE':
        http_response_code(405);
        $response->echoJSONString();
        break;
    default:
        http_response_code(204);
        $response->echoJSONString();
}


