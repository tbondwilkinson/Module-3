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

// Retrieve a list of the 30 most recent posts, and then sort them by their number of votes.
if (isset($_GET['sort'])) {
	if ($_GET['sort'] == "author") {
		$stmt = $mysqli->prepare("SELECT post_timestamp, post, post_id, username, votes FROM 
			(SELECT post_timestamp, post, post_id, username, votes FROM posts ORDER BY post_timestamp DESC LIMIT 30) AS t ORDER BY username DESC");
	}
	else if ($_GET['sort'] == "post") {
		$stmt = $mysqli->prepare("SELECT post_timestamp, post, post_id, username, votes FROM 
			(SELECT post_timestamp, post, post_id, username, votes FROM posts ORDER BY post_timestamp DESC LIMIT 30) AS t ORDER BY post DESC");
	}
	else if ($_GET['sort'] == "votes") {
		$stmt = $mysqli->prepare("SELECT post_timestamp, post, post_id, username, votes FROM 
			(SELECT post_timestamp, post, post_id, username, votes FROM posts ORDER BY post_timestamp DESC LIMIT 30) AS t ORDER BY votes DESC");
	}
	else if ($_GET['sort'] == "time") {
		$stmt = $mysqli->prepare("SELECT post_timestamp, post, post_id, username, votes FROM 
			(SELECT post_timestamp, post, post_id, username, votes FROM posts ORDER BY post_timestamp DESC LIMIT 30) AS t ORDER BY post_timestamp DESC");
	}
}
else {
	$stmt = $mysqli->prepare("SELECT post_timestamp, post, post_id, username, votes FROM 
		(SELECT post_timestamp, post, post_id, username, votes FROM posts ORDER BY post_timestamp DESC LIMIT 30) AS t ORDER BY votes DESC");
}

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();
$stmt->bind_result($post_timestamp, $post, $post_id, $username, $votes);

// Display the post, trimmed to around 50 characters.
while($stmt->fetch()){
	echo "<a href='individual_story.php?post_id=" . $post_id . "'>" . htmlentities(trim_text($post, 50)) . "</a><br>";
  	echo "By " . htmlentities($username) . "<br>";
  	if ($_SESSION['logged_in']) {
    	echo  "<a href='upvote.php?votes=" . $votes . "&post_id=" . $post_id . "'>&uarr;</a>";
  	}
  	echo $votes;
  	echo "<br><br>";
}
$stmt->close();
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
	<div id="toggle-sort">
		<form action="" method="GET">
			Sort the posts by:<br>
			<input type="radio" name="sort" value="author">Author<br>
			<input type="radio" name="sort" value="post">Post Title<br>
			<input type="radio" name="sort" value="votes">Votes<br>
			<input type="radio" name="sort" value="time">Timestamp<br>
			<input type="submit" value="Change sort!">
		</form>
	</div>
</body>