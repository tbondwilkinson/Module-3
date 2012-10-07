<?php
require "database.php";
session_start();

// Verify the user's token.
if ($_SESSION['token'] !== $_POST['token']) {
	header("Location: main.php?error=invalid_token");
	exit;
} 

// Check to see whether the username exists.
if (isset($_POST['commententry']) and isset($_GET['post_id'])) {
	$stmt = $mysqli->prepare("INSERT INTO comments (post_id, comment, username) VALUES (?, ?, ?)");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('dss', $_GET['post_id'], $_POST['commententry'], $_SESSION['username']);
	$stmt->execute();
	$stmt->close();
}
else {
	header("Location: main.php");
	exit;
}

header("Location: individual_story.php?post_id=" . $_GET['post_id']);
exit;
?>