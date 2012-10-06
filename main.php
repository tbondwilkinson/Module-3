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
	$posts[$i] = array("post" => $post, "post_id" => $post_id, "username" => $username);
	$i += 1;
}

echo "<ul>\n";
foreach($posts as &$value){

	printf("\t<li>%s<br><br>\tPosted by %s",
		htmlspecialchars($value["post"]), $username
	);

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
		printf("\t<li>%s<br><br>\tPosted by %s</li>\n", htmlspecialchars($comment), $username);
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
	<a href="commententry.php?post_id=1">Comment Entry</a><br>
	<div id="fupload-logout">
  		<form action="logout_users.php" method="POST">
    		<input type="submit" value="Logout">
  		</form>
	</div>
</body>