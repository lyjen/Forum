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
	<title>Information Technology Society</title>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<img src="img/logo.png" alt="logo" />
			<h2>Information Technology Society</h2>
		</div>
		<div id="navigation">
			<ul>
				<li><a href="#">Home</a></li>
				<li><a href="#">About Us</a></li>
				<li><a href="#">Gallery</a></li>
				<li><a href="#">Contact Us</a></li>
			</ul>
		</div>
		<div id="main_content">
			<div id="left_content">
				<h2>Next Activity: Sportsfest!</h2>
				<img src="img/warriors.jpg" alt="banner" />
			</div>
			<div id="right_content">
				<h5>Unleash the Power w<span>IT</span>hin...</h5>
				<h6>-Ma'am Ina</h6>
				<h5>Ir Rojo Guerero...</h5>
				<h6>-Zeus Buaron</h6>
				<h4>Be a Member of ITS or <a href="signin.php">Signin</a> </h4>
				<form action="process.php" method="post">
					<label for="username">Username:</label>
					<input type="text" name="username" id="username"  />
					<label for="email">Email:</label>
					<input type="text" id="email" name="email"/>
					<label for="password">Password:</label>
					<input type="password" id="password" name="password"/>
					<label for="re_password">Re-Password:</label>
					<input type="password" id="re_password" name="re_password"/>
					<input type="submit" value="register"/>
				</form>
			</div>
			<div id="clear"></div>
		</div>
		<div id="footer">
			<p>
				<?php $includeFile = 'copyright.php';
					if (file_exists($includeFile) && is_readable($includeFile)) 
					{
					include($includeFile);
					}
				?>
			</p>
		</div>
	</div>
</body>
</html>