<?php
/**
 * Created by IntelliJ IDEA.
 * User: edmfperez
 * Date: 3/3/18
 * Time: 8:57 AM
 */


ini_set("allow_url_fopen", 1);
//@Pre:
//@Post:
function DBConnector($serverName,$username,$password,$dbName){
    $db=new mysqli($serverName,$username,$password,$dbName);
    if ($db->connect_errno > 0){
        // print error to web console
        die('Unable to connect to database [' . $db->connect_error . ']');
    }
    else{
        echo "Connected Successfully";
        return $db;
    }
}

/*
,e,   ,88~-_   ,d88~~\                               d8                   888
 "   d888   \  8888       e88~~\  e88~-_  888-~88e _d88__ 888-~\  e88~-_  888
888 88888    | `Y88b     d888    d888   i 888  888  888   888    d888   i 888
888 88888    |  `Y88b,   8888    8888   | 888  888  888   888    8888   | 888
888  Y888   /     8888   Y888    Y888   ' 888  888  888   888    Y888   ' 888
888   `88_-~   \__88P'    "88__/  "88_-~  888  888  "88_/ 888     "88_-~  888
*/



//@Pre:
//@Post:
function getHTTPOrderRequestFromSwift(){

    // ios posts somewhere
    // http_get

    return true;
}


//@Pre: user exists in Database.User
//@Post: user data is returned from User table
function getJSONUser(
    // we should send the iOS user id here to match
    //userID
){
    $json = file_get_contents('http://malkhud2.create.stedwards.edu/user/getUser.php'

    // . '?' . 'user_id' . '=' . 'userID'

    );
    $obj = json_decode($json);
    echo $obj->access_token;
    return $obj;
}

/*
_  _ ____ ____ ____    ___  ____ ___ ____    ____ ____ _  _ ___ ____ ____ _
|  | [__  |___ |__/    |  \ |__|  |  |__|    |    |  | |\ |  |  |__/ |  | |
|__| ___] |___ |  \    |__/ |  |  |  |  |    |___ |__| | \|  |  |  \ |__| |___
*/

/*
 * Parse
 */

// call to mohammad's getUser.php script
$user = getJSONUser(

    //userID

);


// grab the ID info from the string
$user_userID = $user['user_id'];
$user_password = $user['password'];

/*
 *  TO DO
 */
//$user_currLocationLongitude = $user['']
//$user_currLocationLatitude = $user['']
//$user_destLong = $user[''];
//$user_destLat = $user[''];
//$user_email = $user['email'];
//$user_

/*
_                             _             _
  ___  _ __ __| | ___ _ __    ___ ___  _ __ | |_ _ __ ___ | |
 / _ \| '__/ _` |/ _ \ '__|  / __/ _ \| '_ \| __| '__/ _ \| |
| (_) | | | (_| |  __/ |    | (_| (_) | | | | |_| | | (_) | |
 \___/|_|  \__,_|\___|_|     \___\___/|_| |_|\__|_|  \___/|_|
*/







