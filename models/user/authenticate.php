<?php

$username = $_GET['username'];
$password = $_GET['password'];

function main($username,$password) {
    if(isset($username, $password)) {
        include_once userRepository::

        $return = authenticatUserId($username, $password);

        echo $return;

    }
    else {
        $array = array(
            'status' => 'Incorrect parameters'
        );
        echo json_encode($array);
    }
}


main($username,$password);