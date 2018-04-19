<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Indigo</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Forgot Password</h2>
  </div>
	 
  <form method="post" action="forgotPassword.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Your Email</label>
  		<input type="email" name="email" >
  	</div>
  	<div class="input-group">
  		<label>New Password</label>
  		<input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  		<label>Confirm Password</label>
  		<input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="rest_password">Rest Password</button>
  	</div>
  	<p>
  		Not yet a member? <a href="register.php">Sign up</a>
  	</p>
  	<p>
  		Have an account? <a href="login.php">Login</a>
  	</p>
  </form>
</body>
</html>

