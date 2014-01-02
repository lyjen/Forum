<?php
	session_start(); 
	
	require_once('connection.php');
	
	//store success messages, error messages in data array
	$data = NULL;
	
	//redirect user to a page and pass data via session
	function redirect($session_data, $url)
	{
		$_SESSION = $session_data;
		header('location:'.$url);
	}
	
	if(isset($_POST['re_password']))
	{
		//if(!ctype_alnum($_POST['username']))
			//$data['errors'][] = 'The username can only contain letters and digits.';
			
		if (strlen($_POST['username'])<6 )
       	 	$data['errors'][] =  "Username should be 6 characters!";
		
		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === FALSE)
			$data['errors'][] = "Invalid email";
			
		if($_POST['password'] != $_POST['re_password'] OR $_POST['password'] == NULL)
			$data['errors'][] = "Passwords do not match";	
			
		if (strlen($_POST['password'])>25 OR strlen ($_POST['password'])<8)
            $data['errors'][]= "Password must be between 8 and 25 characters";	
		
		//if no errors and email is not in use then add user
		if($data['errors'] == NULL)
		{
			$check_user = $connection->query("SELECT * FROM users WHERE users.email = '".$_POST['email']."' OR users.username ='".$_POST['username']."' ")->fetch_assoc();	
			
			if($check_user == NULL)
			{
				$new_user = $connection->query("INSERT INTO users VALUES ('','". mysql_real_escape_string($_POST['username'])."', '". mysql_real_escape_string($_POST['email'])."', '". mysql_real_escape_string(md5($_POST['password']))."',NOW())");
				
				if($new_user === TRUE)
				{
					$data['registered'] = $_POST['email'];
					redirect($data, 'signin.php');
				}
			}
			else
			{
				$data['errors'][] = "Email or username already in use";
				redirect($data, 'register.php');
			}
		}
		else
			redirect($data, 'register.php');
	}
	else
	{
		//check if user exist in database with given email and password
		$check_user = $connection->query("SELECT * FROM users WHERE users.username = '".$_POST['username']."' AND users.password = '".md5($_POST['password'])."' ")->fetch_assoc();
		
		//if user exist set session variables and redirect user to profile page
		if($check_user != NULL)
		{
			$_SESSION['user_id'] = $check_user['user_id'];
			$_SESSION['username'] = $check_user['username'];
			$_SESSION['login'] = TRUE;	
			
			if($_SESSION['login'] == TRUE)
				header('location: home.php?id='.$check_user['user_id']);
		}
		else
		{
			$data['errors'][] = "Invalid username or password";
				redirect($data, 'signin.php');
		}
	}
	//$_REQUEST to catch both $_POST and $_GET
	//posting status
	if(isset($_REQUEST['share']))
	{
		$message = $_REQUEST['message'];
		$user_id = $_REQUEST['id'];
		
		$share = $connection->query("INSERT INTO posts VALUES ('','". mysql_real_escape_string($message)."',NOW(),'". mysql_real_escape_string($user_id)."')");
		if($share === TRUE)
		{
			redirect($data,'home.php?id='.$user_id.'&share');
		}
	}
	//reply
	if(isset($_REQUEST['comment']))
	{
		$post_id = $_REQUEST['post_id'];
		$user_id = $_REQUEST['id'];
		$reply = $_REQUEST['reply'];
		
		$comment = $connection->query("INSERT INTO replies VALUES ('','". mysql_real_escape_string($reply)."',NOW(),'". mysql_real_escape_string($post_id)."','". mysql_real_escape_string($user_id)."')");
		if($comment === TRUE)
		{
			redirect($data,'home.php?post_id='.$post_id.'&id='.$user_id.'&comment');
		}
	}
	//delete post
		if(isset($_REQUEST['delete_post']))
	{
		$post_id = $_REQUEST['post_id'];
		$user_id = $_REQUEST['id'];
	
		$delete_post = $connection->query("DELETE  FROM posts WHERE post_id =".$post_id);
		if($delete_post === TRUE)
		{
			redirect($data,'home.php?id='.$user_id.'&delete_post');
		}
	}
	//delete reply
	if(isset($_REQUEST['delete_reply']))
	{
		$reply_id = $_REQUEST['reply_id'];
		$post_id = $_REQUEST['post_id'];
		$user_id = $_REQUEST['id'];
	
		$delete_reply = $connection->query("DELETE  FROM replies WHERE reply_id =".$reply_id);
		if($delete_reply === TRUE)
		{
			redirect($data,'home.php?id='.$user_id.'&reply_id='.$reply_id.'&delete_reply');
		}
	}
?>