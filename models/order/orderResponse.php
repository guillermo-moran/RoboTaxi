<?php

/**
 * Created by IntelliJ IDEA.
 * User: salzaidy
 * Date: 3/5/18
 * Time: 12:08 PM
 */

##The Response library makes it very easy to encapsulate data in a tertiary structure to build the json string more easily

require_once __DIR__ . "/response.php";
require_once __DIR__ . "/orderRepository.php";


$response = new Response();
$method = filter_var($_SERVER['REQUEST_METHOD'], FILTER_SANITIZE_STRING);

switch ($method) {
    case 'GET':
        if (isset($_GET['orderId'])) {
            $orderId = filter_var($_GET['orderId'], FILTER_SANITIZE_STRING);
            $order = OrderRepository::getOrderById($orderId);
            $response->pushData($order);
            http_response_code(200);
            $response->echoJSONString();
        } else {
            foreach (OrderRepository::getAllOrders() as $order) {
                $response->pushData($order);
            }
            http_response_code(200);
            $response->echoJSONString();
        }
        break;


    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        if (!isset($data['orderId'])) {
            $response->pushError("(orderId) was not set for $method!");
        }
        if (!isset($data['userId'])) {
            $response->pushError("(userId) was not set for $method!");
        }
        if (!isset($data['vehicleId'])) {
            $response->pushError("(vehicleId) was not set for $method!");
        }
        if (!isset($data['orderDate'])) {
            $response->pushError("(orderDate) was not set for $method!");
        }
        if (!isset($data['startLatitude'])) {
            $response->pushError("(startLatitude) was not set for $method!");
        }
        if (!isset($data['startLongitude'])) {
            $response->pushError("(startLongitude) was not set for $method!");
        }
        if (!isset($data['endLatitude'])) {
            $response->pushError("(endLatitude) was not set for $method!");
        }
        if (!isset($data['endLongitude'])) {
            $response->pushError("(endLongitude) was not set for $method!");
        }
        if (!isset($data['amount'])) {
            $response->pushError("(amount) was not set for $method!");
        }

        if (!$response->getErrorCount()) {
            $order = new Order($data['orderId'], $data['userId'], $data['vehicleId'], $data['orderDate'], $data['startLatitude'],
                $data['startLongitude'], $data['endLatitude'], $data['endLongitude'], $data['amount']);

            $querySuccess = OrderRepository::updateOrder($order);
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
        if (!isset($data['userId'])) {
            $response->pushError("(userId) was not set for $method!");
        }
        if (!isset($data['vehicleId'])) {
            $response->pushError("(vehicleId) was not set for $method!");
        }
        if (!isset($data['orderDate'])) {
            $response->pushError("(orderDate) was not set for $method!");
        }
        if (!isset($data['startLatitude'])) {
            $response->pushError("(startLatitude) was not set for $method!");
        }
        if (!isset($data['startLongitude'])) {
            $response->pushError("(startLongitude) was not set for $method!");
        }
        if (!isset($data['endLatitude'])) {
            $response->pushError("(endLatitude) was not set for $method!");
        }
        if (!isset($data['endLongitude'])) {
            $response->pushError("(endLongitude) was not set for $method!");
        }
        if (!isset($data['amount'])) {
            $response->pushError("(amount) was not set for $method!");
        }


        if (!$response->getErrorCount()) {
            $order = new Order(-1, $data['userId'], $data['vehicleId'], $data['orderDate'], $data['startLatitude'],
                $data['startLongitude'], $data['endLatitude'], $data['endLongitude'], $data['amount']);
            $querySuccess = OrderRepository::insertOrder($order);
            if ($querySuccess) {
                http_response_code(200);
                $response->pushData(['orderId' => Database::getLastKey()]);
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

?>