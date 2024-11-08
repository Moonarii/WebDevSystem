<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<style>
		body {
			font-family: "Arial";
			background-color: #E6E6FA;
		}
		input {
			font-size: 1.5em;
			height: 50px;
			width: 200px;
			border-radius: 12px; /* Curved edges */
		}
		table, th, td {
			border:1px solid black;
		}
		input[type="submit"] {
			font-size: 1.2em;
			height: 45px;
			width: 220px;
			color: #E6E6FA;
			background-color: #4CAF50; /* Green background color */
			border: none;
			border-radius: 12px; /* Curved edges */
			cursor: pointer;
		}

	</style>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<?php if (isset($_SESSION['message'])) { ?>
		<h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
	<?php } unset($_SESSION['message']); ?>
	<h1>Welcome To Moonarii's Web Dev System. Login Now!</h1>
	<form action="core/handleForms.php" method="POST">
		<p>
			<label for="username">Username</label>
			<input type="text" name="username">
		</p>
		<p>
			<label for="password">Password</label>
			<input type="password" name="password">
			<input type="submit" name="loginUserBtn" value="Login">
		</p>
	</form>
	<p>Don't have an account? You may register <a href="register.php">here</a></p>
</body>
</html>