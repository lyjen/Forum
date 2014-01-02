<?php
	//destroy session and redirect user to login page
	session_start();
	session_destroy();
	header('location: index.php');
?>