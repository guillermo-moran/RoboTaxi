<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 24.03.2018
 * Time: 17:41
 *
 * Shared functions for the other vehicle php files
 */

function PHPcredentials()
{
    $a = "localhost";
    $b = "meicherc_WeGo";
    $c = "erQ6340efSCf";
    $d = "meicherc_WeGo";

    return array($a, $b, $c, $d);
}

function checkVehicleID($tmp)
{
    if (is_numeric($tmp) and $tmp <= 1024 and $tmp >= 0) return true;
    else return false;
}

function returnSuccess($msg)
{
    http_response_code(202);
    if ($msg != null) print "SUCCESS: $msg";
}

function returnError($msg)
{
    http_response_code(400);
    if ($msg != null) print "ERROR: $msg";
}