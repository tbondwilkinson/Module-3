<?php
require "database.php";
session_start();

if (isset($_GET["post_id"])) {
	// Delete all the comments associated with the post_id
	$stmt1 = $mysqli->prepare("DELETE FROM comments WHERE post_id = ?");

	if(!$stmt1){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt1->bind_param('s', $_GET["post_id"]);
	$stmt1->execute();
	$stmt1->close();

	// Delete the post with the given post_id
	$stmt = $mysqli->prepare("DELETE FROM posts WHERE post_id = ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('s', $_GET["post_id"]);
	$stmt->execute();
	$stmt->close();

	header("Location: main.php");
	exit;
}
else {
	header("Location: main.php");
	exit;
}
?>