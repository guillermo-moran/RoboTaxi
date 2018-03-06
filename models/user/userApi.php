<?php

/**
 * Created by IntelliJ IDEA.
 * User: Mohammed Alkhudhayr
 * Date: 26-Feb-18
 * Time: 06:53 PM
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
            $user = UserRepository::getUserById($user_id);
            $response->pushData($user);
            http_response_code(200);
            $response->echoJSONString();
        } else {
            foreach (UserRepository::getAllusers() as $user) {
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
        if (!isset($data['user_name'])) {
            $response->pushError("(user_name) was not set for $method!");
        }
        if (!isset($data['user_firstName'])) {
            $response->pushError("(user_firstName) was not set for $method!");
        }
        if (!isset($data['user_lastName'])) {
            $response->pushError("(user_lastName) was not set for $method!");
        }
        if (!isset($data['password'])) {
            $response->pushError("(password) was not set for $method!");
        }
           if (!isset($data['email'])) {
            $response->pushError("(email) was not set for $method!");
        }
        if (!isset($data['credit_card_number'])) {
            $response->pushError("(credit_card_number) was not set for $method!");
        }
        if (!isset($data['card_holder_name'])) {
            $response->pushError("(card_holder_name) was not set for $method!");
        }
        if (!isset($data['credit_expiration'])) {
            $response->pushError("(credit_expiration) was not set for $method!");
        }
        if (!isset($data['credit_ccv'])) {
            $response->pushError("(credit_ccv) was not set for $method!");
        }

        if (!$response->getErrorCount()) {
            $user = new User($data['user_id'], $data['user_name'], $data['user_firstName'], $data['user_lastName'], $data['password'], $data['email'], $data['credit_card_number'], $data['card_holder_name'], $data['credit_expiration'], $data['credit_ccv']);
            $querySuccess = UserRepository::updateUser($user);
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
              if (!isset($data['user_id'])) {
            $response->pushError("(user_id) was not set for $method!");
        }
        if (!isset($data['user_name'])) {
            $response->pushError("(user_name) was not set for $method!");
        }
        if (!isset($data['user_firstName'])) {
            $response->pushError("(user_firstName) was not set for $method!");
        }
        if (!isset($data['user_lastName'])) {
            $response->pushError("(user_lastName) was not set for $method!");
        }
        if (!isset($data['password'])) {
            $response->pushError("(password) was not set for $method!");
        }
           if (!isset($data['email'])) {
            $response->pushError("(email) was not set for $method!");
        }
        if (!isset($data['credit_card_number'])) {
            $response->pushError("(credit_card_number) was not set for $method!");
        }
        if (!isset($data['card_holder_name'])) {
            $response->pushError("(card_holder_name) was not set for $method!");
        }
        if (!isset($data['credit_expiration'])) {
            $response->pushError("(credit_expiration) was not set for $method!");
        }
        if (!isset($data['credit_ccv'])) {
            $response->pushError("(credit_ccv) was not set for $method!");
        }
  
        if (!$response->getErrorCount()) {
            $user = new User(-1, $data['user_id'], $data['user_name'], $data['user_firstName'], $data['user_lastName'], $data['password'], $data['email'], $data['credit_card_number'], $data['card_holder_name'], $data['credit_expiration'], $data['credit_ccv']);
            $querySuccess = UserRepository::insertUser($user);
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
    case 'OPTIONS':
        header('Allow: OPTIONS, GET, POST, PUT, DELETE');
        break;
    default:
        http_response_code(204);
        $response->echoJSONString();
}