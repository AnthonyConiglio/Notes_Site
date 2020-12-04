<?php require_once 'controllers/authController.php'; 

if(isset($_GET['token'])) {
	$token = $_GET['token'];
	verifyUser($token);	
}

if(isset($_GET['password-token'])) {
	$passwordToken = $_GET['password-token'];
	resetPassword($passwordToken);	
}


if(!isset($_SESSION['id'])){
	header('location: login.php');
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	
	<link rel="stylesheet" href="style.css">
								 
<title>Homepage</title>
</head>
	
<body>
	<div class ="container">
	<div class = "row">
	<div class="col-md-4 offset-md-4 form-div login">
		
		<h3>Welcome, <?php echo $_SESSION['username']; ?></h3>
		
		<a href="index.php?logout=1" class= "logout">Logout</a>
		
		<?php if(!$_SESSION['verified']): ?>
		<div class= "alert alert-warning">
		You need to verify your account.
		Sign in to your email account and click on the
		verification link we just emailed you at
		<strong><?php echo $_SESSION['email']; ?></strong>
		</div>
		<?php endif; ?>
		
		<?php if($_SESSION['verified']): ?>
		<?php function function_alert($message) {  
    echo "<script>alert('$message');</script>"; 
} 
function_alert("Welcome you have successfully verified your email"); 
		?>
	<?php endif; ?>
		
					
	
</form>
</div>
</div>
</div>
</body>
</html>
	