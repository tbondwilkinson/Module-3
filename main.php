<?php
session_start();

require "database.php";

// Take the user to the login screen if the user has yet to log in.
if (!$_SESSION['logged_in']) {
	header("Location: login.php");
	exit;
}

$stmt = $mysqli->prepare("SELECT post_timestamp, post, post_id, username FROM posts ORDER BY post_timestamp DESC");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($post_timestamp, $post, $post_id, $username);

$posts = array();

$i = 0;
while($stmt->fetch()){
	$posts[$i] = array("post_timestamp" => $post_timestamp, "post" => $post, "post_id" => $post_id, "username" => $username);
	$i += 1;
}

echo "<ul>\n";
foreach($posts as &$value){

	printf("\t<li>%s<br><br>\tPosted by %s at %s",
		htmlentities($value["post"]), 
		htmlentities($value["username"]), 
		htmlentities($value["post_timestamp"])
	);

	echo "<a href=commententry.php?post_id=" . $value["post_id"] . ">Add a comment!</a>";
	if ($_SESSION['admin']) {
		echo "<a href=delete_post.php?post_id=" . $value["post_id"] . ">Delete</a>";
	}

	$stmt = $mysqli->prepare("SELECT comment_timestamp, comment, comment_id, username FROM comments WHERE post_id = ? ORDER BY comment_timestamp DESC");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('d', $value["post_id"]);

	$stmt->execute();

	$stmt->bind_result($comment_timestamp, $comment, $comment_id, $username);

	echo "\t\t<ul>";
	while($stmt->fetch()){
		printf("\t<li>%s<br><br>\tPosted by %s at %s</li>\n", 
			htmlentities($comment),
			htmlentities($username), 
			htmlentities($comment_timestamp));
		
		if ($_SESSION['admin']) {
			echo "<a href=delete_comment.php?comment_id=" . $comment_id . ">Delete</a>";
		}
	}
	echo "\t\t</ul></li>\n";
}
echo "</ul>\n";
?>
<!DOCTYPE html>
<head>
	<title>Welcome!</title>
</head>
<body>
	IT WORKS!  AND IT IS COOL!<br>
	<a href="storyentry.php">Story Entry</a><br>
	<div id="fupload-logout">
  		<form action="logout_users.php" method="POST">
    		<input type="submit" value="Logout">
  		</form>
	</div>
</body>