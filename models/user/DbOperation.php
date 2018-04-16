<?php
/**
 * Created by IntelliJ IDEA.
 * User: Abo-norah91
 * Date: 3/24/18
 * Time: 9:54 PM
 */

class DbOperation
{
    private $conn;

    //Constructor
    function __construct()
    {
        require_once __DIR__ . "/Constants.php";
        require_once __DIR__ . "/DbConnect.php";

        // require_once dirname(__FILE__) . '/Constants.php';
        // require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    //Function to create a new user
    public function createUser($user_name, $user_firstName, $user_lastName, $email, $pass, $credit_card_number, $card_holder_name, $credit_expiration, $credit_ccv)
    {
        if (!$this->isUserExist($user_name, $email)) {
            $password = md5($pass);
            $stmt = $this->conn->prepare("INSERT INTO user (user_name, user_firstName, user_lastName, email, password, credit_card_number, card_holder_name, credit_expiration, credit_ccv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $user_name, $user_firstName, $user_lastName, $email, $password, $credit_card_number, $card_holder_name, $credit_expiration, $credit_ccv);
            $stmt->execute();

            echo $this->conn->error;
            if (!$this->conn->error) {
                return USER_CREATED;
            } else {
                return USER_NOT_CREATED;
            }
        } else {
            return USER_ALREADY_EXIST;
        }
    }


    private function isUserExist($user_name, $email)
    {
        $stmt = $this->conn->prepare("SELECT user_id FROM user WHERE user_name = ?  OR email = ? ");
        $stmt->bind_param("ss", $user_name, $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
}

?>
