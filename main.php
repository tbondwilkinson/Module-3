<?php
include "abbreviate.php";
require "database.php";

session_start();

// Take the user to the login screen if the user has yet to log in.
if (!$_SESSION['logged_in']) {
	echo "<a href='login.php'>Login!</a><br><br>";
}

if (isset($_GET['error']) and $_GET['error'] == "invalid_token") {
	echo "Invalid token!<br>";
}

$stmt = $mysqli->prepare("SELECT post_timestamp, post, post_id, username, vote FROM posts ORDER BY post_timestamp DESC");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($post_timestamp, $post, $post_id, $username, $vote);

while($stmt->fetch()){
	echo "<a href='individual_story.php?post_id=" . $post_id . "'>" . htmlentities(trim_text($post, 50)) . "</a><br>";
	echo "By " . htmlentities($username) . "\t\t\t" . "<a href='upvote.php'>&uarr</a>" . "<br><br>";
}
?>
<!DOCTYPE html>
<? if ($_SESSION['logged_in']) { ?>
<head>
	<title>Welcome!</title>
</head>
<body>
	<br><br>
	<a href="storyentry.php">Story Entry</a><br>
	<div id="fupload-logout">
  		<form action="logout_users.php" method="POST">
    		<input type="submit" value="Logout">
  		</form>
	</div>
<? } ?>
</body>