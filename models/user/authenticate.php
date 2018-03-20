<?php

$username = $_POST['username'];
$password = $_POST['password'];

function main() {
    if(isset($username, $password)) {
        include_once userRepository::

        $return = authenticatUserId($username, $password);

        echo $return;

    }
    else {
        $array = array(
        {'Status' => "Incorrect parameters"}
        );
        echo json_encode($array);
    }
}

main();