<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 24.03.2018
 * Time: 17:41
 *
 * Shared functions for the other vehicle php files
 */

//#####################################
	
//	SETTINGS
	$minVehicleID = 0;
	$maxVehicleID = 1024;
	
//	SETTINGS FOR vehicleDB DASHBOARD
	$passwordClear = "wego123!" ;
	
//#####################################
 
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
	if ($msg != null)
	{
		print "SUCCESS: $msg  \n\n\n
		<script>setTimeout(function(){window.close();},1000);</script>";
	}
}

function returnError($msg)
{
	http_response_code(400);
	if ($msg != null) print "ERROR: $msg";
}

function returnCurrentDateandTime()
{
	date_default_timezone_set("America/Chicago");
	return date("Y-m-d H:i:s", time());
}


//following functions are for vehicleDB dashboard pages
$password = hash('sha256', $passwordClear);

function printTop()
{
	print "<!DOCTYPE html> \n".
	"<html lang='en'> \n".
	"	<head> \n".
	"		<meta charset='utf-8'> \n".
	"		<title>WeGo vehicleDB Dashboard</title> \n".
	"		<meta name='viewport' content='width=device-width, initial-scale=1'> \n".
	"		<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'> \n".
	"	   <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.4/css/jquery.dataTables.css'> \n".
	"		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script> \n".
	"		<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script> \n".
	"		<script src='https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js'></script> \n".
	"		<script type='text/javascript' class='init'> \n".
	"		$(document).ready(function() { \n".
	"		$('#table1').DataTable( { \n".
	"		\"order\": [[ 0, \"asc\" ]], \n".
	"		\"bLengthChange\": false, \n".
	"		\"lengthMenu\": [[-1], [\"-1\"]], \n".
	"		\"searching\": false, \n".
	"		} ); \n".
	"		} ); \n".
	"		</script> \n".
	"	</head> \n".
	"<nav class=\"navbar navbar-default\"> \n".
	"  <div class=\"container-fluid\"> \n".
	"	<div class=\"navbar-header\"> \n".
	"	  <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#myNavbar\"> \n".
	"		<span class=\"icon-bar\"></span> \n".
	"		<span class=\"icon-bar\"></span> \n".
	"		<span class=\"icon-bar\"></span> \n".				   
	"	  </button> \n".
	"	<span class=\"navbar-brand\">".
	"		<center><p style=\"color:#000000;\"><b>WeGo vehicleDB Dashboard</b></p></center>".
	"	</span>".
	"	</div> \n".
	"	<div class=\"collapse navbar-collapse\" id=\"myNavbar\"> \n".
	"	  <ul class=\"nav navbar-nav\"> \n";
	
	if (isLoggedIn())
	{
		print
		"		<li><a href=\"vehicleDashboardMain.php\">Overview</a></li> \n".
		"		<li><a onclick=\"makeVehiclePrompt()\" href=\"javascript:void(0);\">Make vehicle</a></li> \n".
		"		<li><a href=\"vehicleDashboardSet.php\">Set vehicle data</a></li> \n";
	}
	
	print "		<li><a href=\"vehicleDashboardLogin.php\">Login/Logout</a></li> \n".
	"	  </ul> \n".
	"	</div> \n".
	"  </div> \n".
	"</nav>".
	
	
	"<script> \n".
	"function makeVehiclePrompt()  \n".
	"{  \n".
	"	var newVID = prompt(\"Please enter the new vehicleID:\"); \n".
	"	if (newVID == null || newVID == \"\") \n".
	"	{ \n".
	"		//cancelled \n".
	"	} \n".
	"	else \n".
	"	{ \n".
	"		window.open('./makeVehicle.php?vehicleID=' + newVID, '_blank').focus()\n".
	"		location.reload(); \n".
	"	} \n".
	"}  \n".
	"</script> \n".
	
	
	"<body> \n\n";
}

function printFooter()
{
	print "\n\n</br>".
	"<p style='text-align:center; font-size:9px'><b>© 2018 ME</b></p>".
	"</body> \n".
	"</html>"; 
}

function deleteCookie()
{
	setcookie("login", 'xxxxxx', time()-300); //
}


function checkCredentials($inputPassword)
{
	global $passwordClear; 
	global $password;
	
	if ($inputPassword == $password)
	{
		setcookie("login", $password, time() + 604800); //86400 = 1 day
		return true;
	}
	else
	{
		deleteCookie();
		return false;
	}
}

function isLoggedIn()
{
	global $passwordClear; 
	global $password;
	
	if (isset($_COOKIE['login']) and $_COOKIE['login'] == $password) return true;
	else
	{
		deleteCookie();
		return false;
	}
}

function goToPage($page,$delay)
{
	if ($delay == 0) print "<script type='text/javascript'>window.location = '$page'</script>";
	else
	{
		print "\n\n<script type='text/javascript'>\n".
		"<!--\n".
		"setTimeout(function(){location.href='$page'},$delay);\n".
		"//–>\n".
		"</script>";
	}
}
?>