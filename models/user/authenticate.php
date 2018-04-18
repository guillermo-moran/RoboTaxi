<?php


$user_name = $_POST['user_name'];
$password = $_POST['password'];

function main($user_name,$password) {
    if(isset($user_name, $password)) {

        $db = mysqli_connect('localhost', 'malkhudc_userdb', '123456', 'malkhudc_user');



        $password = md5($password);
        $query = "SELECT * FROM user WHERE user_name='$user_name' AND password= '$password'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {
            $array = array(
                'status' => 'Logged In'
            );
            echo json_encode($array);
        }
        else {
            $array = array(
                'status' => 'Incorrect Password'
            );
            echo json_encode($array);
        }

    }
    else {
        $array = array(
            'status' => 'Incorrect parameters'
        );
        echo json_encode($array);
    }
}


main($user_name,$password);

?>