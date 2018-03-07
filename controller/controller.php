<?php
/**
 * Created by IntelliJ IDEA.
 * User: edmfperez
 * Date: 3/3/18
 * Time: 8:57 AM
 */

// Database initializer(s)
$host='localhost';

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

//@Pre:
//@Post:
function getHTTPOrderRequestFromSwift(){
    return true;
}

//@Pre: user exists in Database.User
//@Post: user data is returned from User table
function getJSONUser(){
    $json = file_get_contents('http://malkhud2.create.stedwards.edu/user/getUser.php');
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



/*
// Mohammad's User dB constants
$userTable_serverName=$host;
$userTable_userName='malkhudc_userdb';
$userTable_password='123456';
$userTable_dataBaseName='malkhudc_user';

// call connection to mohammed's user database...
$userDbConnectionInstance=DBConnector($userTable_serverName,$userTable_userName,$userTable_password,$userTable_dataBaseName);
*/

// call to mohammad's getUser.php script
$user = getJSONUser();
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









