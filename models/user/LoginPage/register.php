<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Indigo</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>
	
  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="user_name" value="<?php echo $user_name; ?>">
  	</div>
  	<div class="input-group">
  	  <label>First Name</label>
  	  <input type="text" name="user_firstName" value="<?php echo $user_firstName; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Last Name</label>
  	  <input type="text" name="user_lastName" value="<?php echo $user_lastName; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <label>Credit Card Holder Name</label>
  	  <input type="text" name="card_holder_name" value="<?php echo $card_holder_name; ?>">
  	</div>
  	  	<div class="input-group">
  	  <label>Credit Card Numner</label>
  	  <input type="text" name="credit_card_number" value="<?php echo $credit_card_number; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Credit Card Expiration</label>
  	  <input type="text" name="credit_expiration" value="<?php echo $credit_expiration; ?>">
  	</div>
  	<div class="input-group">
  	  <label>CCV</label>
  	  <input type="text" name="credit_ccv" value="<?php echo $credit_ccv; ?>">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>