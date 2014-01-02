<?php 	
	//session_start allows us to access the session array
	session_start(); 
	
	if(isset($_SESSION['login']))
		header('location: home.php?id='.$_SESSION['user_id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>Login</title>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	<div id="cover">
		<div id="registration">
			<a href="index.php"><img src="img/home.png" alt="home" /></a>
			<h3>Signin or <a href="register.php">Register</a> </h3>
			<div>
				<?php 	
					if(isset($_SESSION['registered']))
					{
						echo "<div class='success-box'>".$_SESSION['registered']." successfully registered, login now!</div>";
						unset($_SESSION['registered']);
					}
					if(isset($_SESSION['errors']) && $_SESSION['errors'] != NULL)
					{	
				?>
			</div>
			<div class="error-box">
				<?php 			
					foreach($_SESSION['errors'] as $error_message)
					{	
				?>
				<p><?php echo $error_message;?></p>
				<?php			
					}	
					unset($_SESSION['errors']);
					}	
				?>
			</div> 
			<form action="process.php" method="post">
				<label for="username">Username</label>
				<input type="text" id="username" name="username"/>
				<label for="password">Password</label>
				<input type="password" id="password" name="password"/>
				<input type="submit" value="login"/>
			</form>
		</div>
		<div id="clear_left"></div>
	</div>
</body>
</html>