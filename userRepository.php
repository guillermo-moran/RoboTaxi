<?php
/**
 * Created by IntelliJ IDEA.
 * User: Mohammed Alkhudhayr
 * Date: 2/16/18
 * Time: 5:06 PM
 */

require_once __DIR__ . '/user.sql';
require_once __DIR__ . '/User.php';


class userRepository

{

    /**
     * @param int $userId
     * @return user
     */

    public function getUserById(int $user_id)

    {


        $user_id = user::scrubQuery($user_id);
        $rawUserDatum = user::runQuerySingle("SELECT * FROM user WHERE userId='$user_id'");
        if ($rawUserDatum) {
            $returnUser = new stdClass();
            return new User($rawUserDatum['user_id'], $rawUserDatum['$user_name'], $rawUserDatum['$user_firstName'], $rawUserDatum['$user_lastName'], $rawUserDatum['$Email'], $rawUserDatum['$Password'], $rawUserDatum['$credit_card_number'], $rawUserDatum['$card_holder_name'], $rawUserDatum['$credit_expiration'], $rawUserDatum['$credit_ccv']);


            $returnUser -> user_id              = $rawUserDatum['$user_id'];
            $returnUser -> user_name            = $rawUserDatum['$user_name'];
            $returnUser -> user_firstName       = $rawUserDatum['$user_firstName'];
            $returnUser -> user_lastName        = $rawUserDatum['$user_lastName'];
            $returnUser -> Email                = $rawUserDatum['$Email'];
            $returnUser -> Password             = $rawUserDatum['$Password'];
            $returnUser -> credit_card_number   = $rawUserDatum['$credit_card_number'];
            $returnUser -> card_holder_name     = $rawUserDatum['$card_holder_name'];
            $returnUser -> credit_expiration    = $rawUserDatum['$credit_expiration'];
            $returnUser -> credit_ccv           = $rawUserDatum['$credit_ccv'];


            $myJSON = json_encode($returnUser);

            echo $myJSON;

        }

        //if we couldn't find a User with the given id, return null
        return null;

    }
    /**
     * @param $user_name
     * @param $Password
     * @return bool|user
     */
    public static function authenticatUserId($user_name, $password)
    {
        $query = "Select * from user where user_name = '$user_name and Password = '$password";
        $ruselt = mysqli_query($this->connection, $query);
        if(mysqli_num_rows($ruselt) > 0) {

            $json['success'] = 'Welcome' . $user_name;
            echo json_encode($json);
            mysqli_close($this->connection);
        }

        else {
            $query = "Inser into user($user_name, $password) values ('$user_name', '$password')";
            $is_inserted = mysqli_query($this->connection, $query);
            if ($is_inserted == 1){
                $json['success'] = 'Account created, Welcome' .$user_name;
            }
            else{
                $json['error'] = 'Wrong Password';
            }
            echo json_encode($json);
            mysqli_close($this->connection);

        }


        $user = new User();
        if ( isset($_POST['user_name'],$_POST['password'])){
            $user_name = $_POST['$user_name'];
            $password = $_POST['password'];

            if (!empty('$user_name') && !empty('$password')){

                $encrypted_password = md5($password);
                $user -> does_user_exist($user_name,$encrypted_password);
            }
            else{

                echo json_encode("You Must fill both fields");
            }
        }


    }
}



?>