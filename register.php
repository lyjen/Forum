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
	<title>Register</title>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	<div id="cover">
		<div id="registration">
			<a href="index.php"><img src="img/home.png" alt="home" /></a>
			<h3>Register or <a href="signin.php">Signin</a> </h3>
			<div class="error-box">
				<?php 		
					if(isset($_SESSION['errors']) && $_SESSION['errors'] != NULL)
					{	
				?>
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
				<label for="username">Username:</label>
				<input type="text" name="username" id="username" />
				<label for="email">Email:</label>
				<input type="text" id="email" name="email"/>
				<label for="password">Password:</label>
				<input type="password" id="password" name="password"/>
				<label for="re_password">Re-Password:</label>
				<input type="password" id="re_password" name="re_password"/>
				<input type="submit" value="register"/>
			</form>
		</div>
		<div id="clear_left"></div>
	</div>
</body>
</html>