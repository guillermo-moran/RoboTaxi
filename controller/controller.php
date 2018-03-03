<?php
/**
 * Created by IntelliJ IDEA.
 * User: edmfperez
 * Date: 3/3/18
 * Time: 8:57 AM
 */

// Database initializer(s)
$host='localhost';

/*
_  _ ____ ____ ____    ___  ____ ___ ____    ____ ____ _  _ ___ ____ ____ _
|  | [__  |___ |__/    |  \ |__|  |  |__|    |    |  | |\ |  |  |__/ |  | |
|__| ___] |___ |  \    |__/ |  |  |  |  |    |___ |__| | \|  |  |  \ |__| |___
*/

// Mohammad's User dB constants
$userTable_serverName=$host;
$userTable_userName='malkhudc_userdb';
$userTable_password='123456';
$userTable_dataBaseName='malkhudc_user';

// call connection to mohammed's user database...
$userDbConnectionInstance=DBConnect($userTable_serverName,$userTable_userName,$userTable_password,$userTable_dataBaseName);
// query call to select uid that matches







//@Pre:
//@Post:
function DBConnect($serverName,$username,$password,$dbName){
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
    return true;

}

?>