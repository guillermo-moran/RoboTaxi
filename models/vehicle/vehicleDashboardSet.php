<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 29.03.2018
 * Time: 12:45
 *
 * vehicleDB Dashboard: Set vehicle page
 */
 
//For debugging purposes
//var_dump($_GET);
//var_dump($_POST);
//var_dump($_COOKIE);
 
require './sharedFunctions.php';

printTop();

//section copied (start) from getAllVehicles.php, could not use include/require!
$login = PHPcredentials();
$db = new mysqli($login[0], $login[1], $login[2], $login[3]);
$rs = $db->query("select count(*) from WeGoVehicleDB")->fetch_assoc();
//section (end) from getAllVehicles.php

if (isLoggedIn())
{	
	if (isset($_GET['selectVehicleID']))
	{
		print
		"<p><b>Vehicle data change request:</b></p> \n";
		
		$url = "setVehicle.php?vehicleID=" . $_GET['selectVehicleID'];
		
		if (isset($_GET['newOwnerID']) and $_GET['newOwnerID'] != null)			$url = $url . "&ownerID=" . $_GET['newOwnerID'];
		if (isset($_GET['newCapacity']) and $_GET['newCapacity'] != null)		$url = $url . "&capacity=" . $_GET['newCapacity'];
		if (isset($_GET['newInService']) and $_GET['newInService'] != null)		$url = $url . "&inService=" . $_GET['newInService'];
		
		print $url;
		
		print "</br></br><button onclick=\"confirm()\">Confirm</button>".		
		"<script> \n".
		"function confirm()  \n".
		"{  \n".
		"	window.open('" . $url . "', '_blank').focus(); \n".
		"	window.location.href = './vehicleDashboardMain.php'; \n".
		"}  \n".
		"</script> \n";
	}
	else
	{	
		print
		"<p><b>Only fill in the fields to be changed!</b>".
		"</br>inUse and location data can only be changed programmatically by the iOS app, vehicles that are currently in use cannot be changed.</b></p>".
		"<form action=\"./vehicleDashboardSet.php\">".
		
		"<p>vehicleID: <select name='selectVehicleID'>\n";
		
		//section copied (start) from getAllVehicles.php, could not use include/require!
		for ($x = $minVehicleID; $x <= $maxVehicleID; $x++)
		{
			$rs = $db->query("select * from WeGoVehicleDB where vehicleID = $x")->fetch_assoc();

			$vehicle = new stdClass();
			$vehicle -> vehicleID           = $rs['vehicleID'];
			$vehicle -> ownerID             = $rs['ownerID'];
			$vehicle -> capacity            = $rs['capacity'];
			$vehicle -> inService           = $rs['inService'];
			$vehicle -> inUse               = $rs['inUse'];
			$vehicle -> currentLatitude     = $rs['currentLatitude'];
			$vehicle -> currentLongitude    = $rs['currentLongitude'];	
			$vehicle -> lastUpdate		    = $rs['lastUpdate'];
					
			if ($rs['vehicleID'] != null and $rs['inUse'] == 0) //MODIFIED
			//section (end) from getAllVehicles.php
			{
				print "ownerID: <option value='" .  "$vehicle->vehicleID" . "'>$vehicle->vehicleID</option>";
			}
		}
		print "</select></p> \n".
		"<p>ownerID: <input type=\"number\" name=\"newOwnerID\"></p> \n".
		"<p>capacity: <input type=\"number\" name=\"newCapacity\"></p> \n".		
		"<p>inService: <input type=\"radio\" name=\"newInService\" value=\"1\"> Yes \n".
		"<input type=\"radio\" name=\"newInService\" value=\"0\"> No</p> \n".
		
		"<p><input type=\"submit\" value=\"Submit\"></p>".
		"</form> \n";
	}
}
else
{
	print "<center><h4>Please login first! (<a href='vehicleDashboardLogin.php'>go to Login</a>)</h4></center>";
}

printFooter();
?>