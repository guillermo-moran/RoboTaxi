<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marcus Eicher
 * Date: 29.03.2018
 * Time: 12:45
 *
 * vehicleDB Dashboard: Login and logout
 */
 
//For debugging purposes
//var_dump($_GET);
//var_dump($_POST);
//var_dump($_COOKIE);
 
require './sharedFunctions.php';

printTop();

if (isset($_GET['logout']))
{
	deleteCookie();
	
	print "<center><h4>Login cookie cleared!</br>(Redirecting...)</h4></center>";
	goToPage("vehicleDashboardLogin.php",1000);
}
else
{
	if (isset($_POST['userPassword']))
	{
		$input = hash('sha256',$_POST['userPassword']);
	
		if (checkCredentials($input) == true)
		{
			print "<center><h4>Login successful!</br>(Redirecting...)</h4></center>";
			goToPage("vehicleDashboardMain.php",1000);
		}
		else
		{
			print "<center><h4>Login failed!</br>(Redirecting...)</h4></center>";
			goToPage("vehicleDashboardLogin.php",1000);
		}	
	}
	else
	{
		if (isLoggedIn() == true)
		{
			print "<center><p>Currently logged in</br>(<a href='vehicleDashboardLogin.php?logout'>Log out</a>)</p></center>";
		}
		else
		{
			print  "<center><p><b>WeGo Vehicle Administration Area</b></p>".
			"<p>Please enter password:</p>".
			"<form action='vehicleDashboardLogin.php' method='post'>\n" .
			"<input type='password' name = 'userPassword' maxlength='40' style='width: 180px; height: 30px; font-size:24px'>".
			"</br></br><input type='submit' name='btnSubmit' value='Login' style='width: 180px; height: 30px'></td>\n" .
			"</form></center>";
		}
	}
}

printFooter();
 ?>