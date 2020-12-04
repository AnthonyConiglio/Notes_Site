<?php 
require_once 'controllers/authController.php'; 
/** @var Connection $connection */
$connection = require_once 'pdo.php';
// Read notes from database
$notes = $connection->getNotes();


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
	


$currentNote = [
    'id' => '',
    'title' => '',
    'description' => '',
	'categories' => ''
];


if (isset($_GET['id'])) {
    $currentNote = $connection->getNoteById($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="app.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="style.css">
<title>Homepage</title>
	
</head>
<body>

<div class="col-md-4 offset-md-4 form-div">
	
<h3>Welcome, <?php echo $_SESSION['username']; ?></h3>
<a href="index.php?logout=1" class= "logout">Logout</a>
	
	
<?php if($_SESSION['verified']): ?>
		<?php function function_alert($message) {  
    echo "<script>alert('$message');</script>"; 
} 
		
function_alert("Welcome you have successfully verified your email"); 
		?>
	<?php endif; ?>

	
<div>
	
<form method="post" action="create.php">
<h3 class="text-center">Notes</h3>
	
<div class="post-note">
<input type="hidden" name="id" value="<?php echo $currentNote['id'] ?>">
</div>
		
<div class="post-note">
<input type="text" name="title" placeholder="Note title" autocomplete="off" value="<?php echo $currentNote['title']; ?>" class="form-control form-control-lg">
</div>
<br>
			
<div class="post-note">
<textarea name="description" cols="65" rows="4"placeholder="Note Description"><?php echo $currentNote['description'] ?></textarea>
</div>
<br>
<div class="post-note">
   <label><b>Category</b></label> <br>   
   <select name="categories" id="categories">
   <option value="No label" selected>No label</option>
   <option value="Grocery">Grocery</option>
    <option value="Important Information">Important Information</option>
    <option value="Account Password">Account Password</option>
    <option value="Todo List">Todo List</option>
    </select> 
	</div>
	<br>
	
<div class="post-note">
 <button>
            <?php if ($currentNote['id']): ?>
                Update
            <?php else: ?>
                New note
            <?php endif ?>
        </button>
	</div>
</form>
    </form>
    <div class="notes">
        <?php foreach ($notes as $note): ?>
            <div class="note">
                <div class="title">
                    <a href="?id=<?php echo $note['id'] ?>">
                        <?php echo $note['title'] ?>
                    </a>
                </div>
                <div class="description">
                    <?php echo $note['description'] ?>
                </div>
				
				 <div class="categories">
					 <strong><?php echo $note['categories'] ?></strong>
                </div>
				<br>
				
                   <small><?php echo date('d/m/Y H:i', strtotime($note['create_date'])) ?></small>
                    <form action="delete.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $note['id'] ?>">
                    <button class="close">X</button>
					
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
</body>
</html>
