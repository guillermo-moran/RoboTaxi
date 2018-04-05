<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 29.03.2018
 * Time: 12:45
 *
 * vehicleDB Dashboard: Main page
 */
 
//For debugging purposes
//var_dump($_GET);
//var_dump($_POST);
//var_dump($_COOKIE);
 
require './sharedFunctions.php';

printTop();

if (isLoggedIn())
{
	if (file_exists("./error_log"))
	{
		print "<center><p style=\"color:red;\">There is a PHP error log saved on the server!</p></center></br>";
	}
	
	
	//section copied (start) from getAllVehicles.php, could not use include/require!
	$login = PHPcredentials();
	$db = new mysqli($login[0], $login[1], $login[2], $login[3]);

	$rs = $db->query("select count(*) from WeGoVehicleDB")->fetch_assoc();
	$count = $rs['count(*)'];
	//section (end) from getAllVehicles.php
	
	
	print
	"                  <table id='table1' class='display' cellspacing='0' width='100%'> \n".
	"                        <thead> \n".
	"                            <tr> \n".
	"                               <th>vehicleID</th> \n".
	"								<th>ownerID</th> \n".
	"								<th>capacity</th> \n".
	"								<th>inService</th> \n".
	"								<th>inUse</th> \n".
	"								<th>current position</th> \n".
	"								<th>last db update</th> \n".
	"								<th>delete vehicle</th> \n".
	"                            </tr> \n".
	"                        </thead> \n".
	"                        <tbody> \n";


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
				
		if ($vehicle -> vehicleID != null)
		//section (end) from getAllVehicles.php
		{
			$currentPosition = $rs['currentLatitude'] . "," . $rs['currentLongitude'];
			
			print "<tr> \n";
			print "<td>" . $rs['vehicleID'] . "</td> \n";
			print "<td>" . $rs['ownerID'] . "</td> \n";
			print "<td>" . $rs['capacity'] . "</td> \n";
			
			if ($rs['inService'] == "0") print "<td>NO</td> \n";
			if ($rs['inService'] == "1") print "<td>YES</td> \n";
			
			if ($rs['inUse'] == "0") print "<td>NO</td> \n";
			if ($rs['inUse'] == "1") print "<td>YES</td> \n";
					
			print "<td><a target='_blank' href='https://www.google.com/maps/place/". $currentPosition ."'>" . $currentPosition . "</a></td> \n";
			print "<td>" . $rs['lastUpdate'] . "</td> \n";
			
			if ($rs['inUse'] == "0")
			{
				print "<td><button onclick='delete" . $x ."()'>Delete</button></td>";		
				print
				"<script> \n".
				"	function delete" . $x ."() { \n".
				"	if (confirm('Do you really want to delete vehicleID " . $rs['vehicleID'] . "?')) \n".
				"		{ \n".
				"			window.open('./removeVehicle.php?vehicleID=" . $rs['vehicleID'] ."', '_blank').focus()\n".
				"			location.reload(); \n".
				"		} \n".
				"	} \n".
				"</script> \n";
			}
			else print "<td>N/A <i>(vehicle in use)</i></td>";
			
			print "</tr> \n";
		}
	}
	$db -> close();

	print "</table>";
	print "<br/>";
	
	print $json;
}
else
{
	print "<center><h4>Please login first! (<a href='vehicleDashboardLogin.php'>go to Login</a>)</h4></center>";
}

printFooter();
?>