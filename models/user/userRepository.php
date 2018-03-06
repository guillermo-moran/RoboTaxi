<?php
/**
 * Created by IntelliJ IDEA.
 * User: Mohammed Alkhudhayr
 * Date: 2/16/18
 * Time: 5:06 PM
 */

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/User.php';


class userRepository

{

    /**
     * @param int $userId
     * @return user
     */

    public static function getUserById(int $user_id)

    {


        $user_id = user::scrubQuery($user_id);

        $rawUserDatum = user::runQuerySingle("SELECT * FROM user WHERE user_id='$user_id'");

        if ($rawUserDatum) {

            return new User($rawUserDatum['user_id'], $rawUserDatum['$user_name'], $rawUserDatum['$user_firstName'],
                $rawUserDatum['$user_lastName'], $rawUserDatum['$email'], $rawUserDatum['$password'],
                $rawUserDatum['$credit_card_number'], $rawUserDatum['$card_holder_name'],
                $rawUserDatum['$credit_expiration'], $rawUserDatum['$credit_ccv']);


        }

        //if we couldn't find a User with the given id, return null
        return null;

    }



    //this is the same as above, except it gets *all* the users associated with a username

    public static function getUsersByUsername(string $user_name)
    {
        $user_name = Database::scrubQuery($user_name);

        $rawUserData = Database::runQueryAll("SELECT * FROM user WHERE user_name='$user_name'");
        if ($rawUserData) {
            $output = [];
            foreach ($rawUserData as $rawUserDatum) {
                $output[] = new User($rawUserDatum['user_id'], $rawUserDatum['$user_name'], $rawUserDatum['$user_firstName'],
                    $rawUserDatum['$user_lastName'], $rawUserDatum['$email'], $rawUserDatum['$password'],
                    $rawUserDatum['$credit_card_number'], $rawUserDatum['$card_holder_name'],
                    $rawUserDatum['$credit_expiration'], $rawUserDatum['$credit_ccv']);
            }
            return $output;
        }
        return [];
    }


    /**
     * @return array
     */
    public static function getAllUsers()
    {
        $rawUserData = Database::runQueryAll("");
        if ($rawUserData) {
            $output = [];
            foreach ($rawUserData as $rawUserDatum) {
                $output[] = User($rawUserDatum['user_id'], $rawUserDatum['$user_name'], $rawUserDatum['$user_firstName'],
                    $rawUserDatum['$user_lastName'], $rawUserDatum['$email'], $rawUserDatum['$password'],
                    $rawUserDatum['$credit_card_number'], $rawUserDatum['$card_holder_name'],
                    $rawUserDatum['$credit_expiration'], $rawUserDatum['$credit_ccv']);
            }
            return $output;
        }
        return [];
    }




    public static function insertUser(User $user) 
    {
        $user_id = $user->getUserId();
        $user_name = $user->getUserName();
        $user_firstName = $user->getUserFirstName();
        $user_lastName = $user->getUserLastName();
        $email = $user->getUserEmail();
        $password = $user->getUserPassword();
        $credit_card_number = $user->getCreditCardNumber();
        $card_holder_name = $user->getCardHolderName();
        $credit_expiration = $user->getCardExperationDate();
        $credit_ccv = $user->getCcv();

        return Database::runQuerySingle("INSERT INTO User(user_id, user_name, user_firstName, user_lastName,
          email, password, credit_card_number, card_holder_name, credit_expiration, credit_ccv) 
          VALUES ('$user_id', '$user_name', '$user_firstName', '$user_lastName', '$email', '$password',
           '$credit_card_number', '$card_holder_name', '$credit_expiration', '$credit_ccv')");

    }

    public static function updateUser(User $user) 
    {
        $user_id = $user->getUserId();
        $user_name = $user->getUserName();
        $user_firstName = $user->getUserFirstName();
        $user_lastName = $user->getUserLastName();
        $email = $user->getUserEmail();
        $password = $user->getUserPassword();
        $credit_card_number = $user->getCreditCardNumber();
        $card_holder_name = $user->getCardHolderName();
        $credit_expiration = $user->getCardExperationDate();
        $credit_ccv = $user->getCcv();

        return Database::runQuerySingle("UPDATE user SET user_id = '$user_id', user_name = '$user_name',
          user_firstName = '$user_firstName', user_lastName = '$user_lastName', email = '$email',
           password = '$password', credit_card_number = '$credit_card_number', card_holder_name = '$card_holder_name',
            credit_expiration = '$credit_expiration', credit_ccv = '$credit_ccv' WHERE user_id = '$user_id'");

    }

/**
     * @param $user_name
     * @param $Password
     * @return bool|user
     */
    public function authenticatUserId($user_name, $password)
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



