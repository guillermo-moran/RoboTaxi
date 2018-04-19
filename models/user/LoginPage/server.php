<?php
session_start();

// initializing variables
$user_name = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'malkhudc_userdb', '123456', 'malkhudc_user');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $user_name = mysqli_real_escape_string($db, $_POST['user_name']);
  $user_firstName = mysqli_real_escape_string($db, $_POST['user_firstName']);
  $user_lastName = mysqli_real_escape_string($db, $_POST['user_lastName']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $card_holder_name = mysqli_real_escape_string($db, $_POST['card_holder_name']);
  $credit_card_number = mysqli_real_escape_string($db, $_POST['credit_card_number']);
  $credit_expiration = mysqli_real_escape_string($db, $_POST['credit_expiration']);
  $credit_ccv = mysqli_real_escape_string($db, $_POST['credit_ccv']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($user_name)) { array_push($errors, "Username is required"); }
  if (empty($user_firstName)) { array_push($errors, "First Name is required"); }
  if (empty($user_lastName)) { array_push($errors, "Last Name is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match"); }
  if (empty($card_holder_name)) { array_push($errors, "Credit Card Holder Name is required"); }
  if (empty($credit_card_number)) { array_push($errors, "Credit Card Numner is required"); }
  if (empty($credit_expiration)) { array_push($errors, "Credit Card Expiration is required"); }
  if (empty($credit_ccv)) { array_push($errors, "CCV is required");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM user WHERE user_name='$user_name' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['user_name'] === $user_name) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO user (user_name, user_firstName, user_lastName, email, password, card_holder_name, credit_card_number, credit_expiration, credit_ccv) 
  			  VALUES('$user_name','$user_firstName', '$user_lastName','$email', '$password', '$card_holder_name','$credit_card_number','$credit_expiration','$credit_ccv')";
  	mysqli_query($db, $query);
  	$_SESSION['user_name'] = $user_name;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: login.php');
  }
}

if (isset($_POST['login_user'])) {
  $user_name = mysqli_real_escape_string($db, $_POST['user_name']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($user_name)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM user WHERE user_name='$user_name' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['user_name'] = $user_name;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: welcome.php');
  	}else {
  		array_push($errors, "Wrong user_name/password combination");
  	}
  }
}

if (isset($_POST['rest_password'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

if (empty($email)) {
  	array_push($errors, "Email is required");
  }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match"); }
	
  if (count($errors) == 0) {
  	$password = md5($password_1);
  	$query = "UPDATE user SET password='$password' where email='$email'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) != 1) {
  	  $_SESSION['password'] = $password;
  	  $_SESSION['success'] = "Your password updated";
  	  header('location: login.php');
  	}else {
  		array_push($errors, "Wrong password combination");
  	}
  }
}
?>