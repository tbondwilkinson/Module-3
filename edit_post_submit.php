<?php
require "database.php";
session_start();

// Verify the user's token.
if (!isset($_POST['token']) or $_SESSION['token'] !== $_POST['token']) {
	header("Location: main.php?error=invalid_token");
	exit;
} 

if (isset($_POST['post']) and isset($_POST['post_id'])) {
	$stmt = $mysqli->prepare("UPDATE posts SET post=? WHERE post_id = ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('ss', $_POST['post'], $_POST["post_id"]);
	$stmt->execute();
	$stmt->close();

	header("Location: individual_story.php?post_id=" . $_POST['post_id']);
	exit;
} else {
	header("Location: main.php");
	exit;
}
?>