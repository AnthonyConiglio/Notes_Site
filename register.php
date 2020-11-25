<?php require_once 'controllers/authController.php'; ?>
<!doctype html>
<html lang="en">
	 
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	
	<link rel="stylesheet" href="style.css">
								 
<title>Registration</title>
</head>
<body>
	<div class ="container">
	<div class = "row">
	<div class="col-md-4 offset-md-4 form-div">
	
<form method="post" action="register.php">
<h3 class="text-center">Register</h3>
	
	<?php if(count($errors) > 0): ?>
	<div class="alert alert-danger">
	<?php foreach($errors as $error): ?>	
	<li><?php echo $error; ?></li>
	<?php endforeach; ?>
	
	</div>
	<?php endif; ?>

<div class="form-group">
<label for="username">Create Username:</label>
<input type="text" name="username" value="<?php echo $username; ?>" class="form-control form-control-lg">
</div>
	
<div class="form-group">
<label for="email"> Enter Email:</label>
<input type="email" name="email" value="<?php echo $email; ?>" class="form-control form-control-lg">
</div>
	
<div class="form-group">
<label for="password"> Create Password:</label>
<input type="password" name="password" class="form-control form-control-lg">
</div>
	
<div class="form-group">
<label for="passwordConf">Confirm Password:</label>
<input type="password" name="passwordConf" class="form-control form-control-lg">
</div>
	
<div class="form-group">
<button type="submit" name="signup-btn" class="btn btn-primary btn-block btn-lg">Register</button>
</div>	
	
<p class="test-center"> Already have an account? <a href="login.php">Login</a></p>
	
</form>
</div>
</div>
</div>
</body>
</html>
