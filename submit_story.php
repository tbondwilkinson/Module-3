<?php
require "database.php";
session_start();

// Verify the user's token.
if ($_SESSION['token'] !== $_POST['token']) {
	header("Location: main.php?error=invalid_token");
	exit;
}

// Check to see whether the username exists.
if (isset($_POST['storyentry'])) {
	$stmt = $mysqli->prepare("insert into posts (post, username) values (?, ?)");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('ss', $_POST['storyentry'], $_SESSION['username']);
	$stmt->execute();
	$stmt->close();
}

header("Location: main.php");
exit;
?>