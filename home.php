<?php
	session_start(); 
	require_once('connection.php');
	
	$user = $connection->query("SELECT * FROM users where users.user_id = '".$_GET['id']."' ")->fetch_assoc();
	$display = $connection->query("SELECT posts.*,users.* FROM posts, users where posts.user_id = users.user_id ORDER BY posts.post_id DESC");
	$user_name = $connection->query("SELECT * FROM users")->fetch_assoc(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>Home - Information Technology Society</title>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<img src="img/logo.png" alt="logo" />
			<h2>Information Technology Society</h2>
		</div>
		<div id="head_navigation">
			<ul>
				<li> Hi<a href="profile.php?id=<?php echo $user['user_id']; ?>"> <?php echo $user['username']; ?></a> </li>
				<li><a href="signout.php">Logout</a></li>
			</ul>
		</div>
		<div id="main_content">
			<div id="user_details">
				<img src="img/user.png" alt="picture" />
				<h4><?php echo $user['username']; ?>!</h4>		
				<h4><?php echo $user['email']; ?></h4>
				<h6><?php echo date("M d, Y ", strtotime($user['registered'])); ?></h6>
			</div>
			<div id="wall">
				<h3>Echo Your Voice!</h3>
				<form name="post" id="post" method="post" action="process.php?share&id=<?php echo $user['user_id']; ?>">
					<textarea name="message" id="message" cols="30" rows="8"></textarea>
					<input type="submit" id="share" value="share" name="share"  />
				</form>			
				<h5>Recent Posts</h5>
				<div id="wall_posts"> 
					<?php
						while($row = $display->fetch_assoc())
						{
							$id=$row['post_id'];
							echo "<h4>".$row['username']."</h4>";
							echo "<p>".$row['message']."</p>";
							
							if( $user['user_id'] == $row['user_id'])
							{
								echo "<a href='process.php?delete_post&id=".$user['user_id']."&post_id=".$row['post_id']."'>";
								echo "<img src='img/x.png' alt='delete' title='delete' /></a>";
							} 
							echo "<h6>". date("M d, Y H:i", strtotime($row['date_posted'])) ."</h6>";
							
							$replies = $connection->query("SELECT * FROM replies WHERE post_id='$id'");
							while($reply = $replies->fetch_assoc())
							{
								$name = $reply['reply_id'];
								$reply_name = $connection->query("SELECT users.username from users LEFT JOIN replies on users.user_id = replies.user_id WHERE reply_id = '$name'")->fetch_assoc();
								
								echo "<div id='reply_posts'>";
								echo "<h5>".$reply_name['username']."</h5>";
								echo "<p>".$reply['reply_message']."</p>";
								
								if( $user['user_id'] == $reply['user_id'])
								{
									echo "<a href='process.php?delete_reply&id=".$user['user_id']."&reply_id=".$reply['reply_id']."'>";
									echo "<img src='img/x.png' alt='delete' title='delete' /></a>";
								}
								echo "<h6>". date("M d, Y H:i", strtotime($reply['reply_posted']))."</h6>";
								echo "</div>";	
							}						
							echo "<form name='replies' id='reply_post' method='post' action='process.php?comment&id=".$user['user_id']."'>";
							echo "<textarea name='reply' id='reply' cols='20' rows='2'></textarea>";
							echo "<input type='submit' value='comment' id='comment' name='comment' />";
							echo "<input type='hidden' name='post_id' value='".$row['post_id']."'  />";
							echo "</form>";	
						}
					?>
					<div id="clear_right"></div>
				</div>
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
