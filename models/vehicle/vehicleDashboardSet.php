<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 29.03.2018
 * Time: 12:45
 *
 * vehicleDB Dashboard: Make vehicle page
 */
 
//For debugging purposes
//var_dump($_GET);
//var_dump($_POST);
//var_dump($_COOKIE);
 
require './sharedFunctions.php';

printTop();

if (isLoggedIn())
{
	print "<center><h4>Feature still in development!</h4></center>";
}
else
{
	print "<center><h4>Please login first! (<a href='vehicleDashboardLogin.php'>go to Login</a>)</h4></center>";
}

printFooter();
 ?>