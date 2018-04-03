<?php
/**
 * Created by IntelliJ IDEA.
 * User: salzaidy
 * Date: 2/16/18
 * Time: 5:06 PM
 */

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Order.php';


class OrderRepository
{
    /**
     * @param int $orderId
     * @return Order
     */


    public static function getOrderById(int $orderId) {

        //We want to make sure to mitigate SQL injection attacks!
        $orderId = Database::scrubQuery($orderId);

        //get the raw data from the database
        $rawOrderDatum = Database::runQuerySingle("SELECT * FROM orderdb WHERE orderId ='$orderId'");

        //our Database class will give us a one dimensional array with the result of our query, or an empty array
        //the keys of the array will be txhe selected columns, in our case all columns
        //now let's make sure we actually got something back

        if ($rawOrderDatum) {
            return new Order($rawOrderDatum['$orderId'], $rawOrderDatum['$userId'], $rawOrderDatum['$userName'], $rawOrderDatum['$orderDate'],
                $rawOrderDatum['$startLatitude'], $rawOrderDatum['$startLongitude'], $rawOrderDatum['$endLatitude'],
                $rawOrderDatum['$endLongitude'], $rawOrderDatum['$amount']);
        }
        //if we couldn't find a Order with the given id, return null
        return null;
    }





    //this is the same as above, except it gets *all* the Order associated with a user ID
    public static function getOrderByUserId(string $userId)
    {
        $userId = Database::scrubQuery($userId);
        $rawOrderDatum = Database::runQueryAll("SELECT * FROM orderdb WHERE userId ='$userId'");

        if ($rawOrderDatum) {
            $output = [];
            foreach ($rawOrderDatum as $rawOrderDatum) {
                $output[] = new Order($rawOrderDatum['$orderId'], $rawOrderDatum['$userId'], $rawOrderDatum['$userName'],
                    $rawOrderDatum['$orderDate'], $rawOrderDatum['$startLatitude'], $rawOrderDatum['$startLongitude'],
                    $rawOrderDatum['$endLatitude'], $rawOrderDatum['$endLongitude'], $rawOrderDatum['$amount']);
                return $output;
            }
            return [];
        }
    }




    // this gets All orders
    public static function getAllOrders()
    {
        $rawOrderDatum = Database::runQueryAll("SELECT * FROM orderdb");
        if ($rawOrderDatum) {
            $output = [];
            foreach ($rawOrderDatum as $rawOrderDatum) {
                $output[] = new Order($rawOrderDatum['$orderId'], $rawOrderDatum['$userId'], $rawOrderDatum['$userName'],
                    $rawOrderDatum['$orderDate'], $rawOrderDatum['$startLatitude'], $rawOrderDatum['$startLongitude'],
                    $rawOrderDatum['$endLatitude'], $rawOrderDatum['$endLongitude'], $rawOrderDatum['$amount']);
            }
            return $output;
        }
        return [];
    }

    /**
     * @param Order $order
     * @return bool
     */
    public static function insertOrder(Order $order)
    {
        $userId = $order->getUserId();
        //$userName = $order->getUserName();
        $vehicleId = $order->getVehicleId();
        $orderDate = $order->getOrderDate();
        $startLatitude = $order->getStartLatitude();
        $startLongitude = $order->getStartLongitude();
        $endLatitude = $order->getEndLatitude();
        $endLongitude = $order->getEndLongitude();
        //$amount = $order->getAmount();

        return Database::runQuerySingle("INSERT INTO orderdb(userName, vehicleId, orderDate, startLatitude,
                                        startLongitude, endLatitude, endLongitude, amount)
                                        VALUES ('$userId', '$userName', '$vehicleId', '$orderDate', '$startLatitude', 
                                        '$startLongitude','$endLatitude', '$endLongitude', '$amount')");
    }

    /**
     * @param Order $order
     * @return bool
     */
    public static function updateOrder(Order $order)
    {
        $orderId = $order->getOrderId();
        $userId = $order->getUserId();
        $userName = $order->getUserName();
        $vehicleId = $order->getVehicleId();
        $orderDate = $order->getOrderDate();
        $startLatitude = $order->getStartLatitude();
        $startLongitude = $order->getStartLongitude();
        $endLatitude = $order->getEndLatitude();
        $endLongitude = $order->getEndLongitude();
        $amount = $order->getAmount();


        return Database::runQuerySingle("UPDATE orderdb SET userId = '$userId', userName = '$userName', vehicleId = '$vehicleId',
                                        orderDate = '$orderDate', startLatitude = '$startLatitude', startLongitude = '$startLongitude',
                                         endLatitude = '$endLatitude', endLongitude = '$endLongitude', amount = '$amount'
                                          WHERE orderId = '$orderId'");
    }




}



?>