<?php
require "database.php";
session_start();

if (isset($_GET["comment_id"]) and isset($_GET["post_id"])) {
	// Delete the comment from the table
	$stmt = $mysqli->prepare("DELETE FROM comments WHERE comment_id = ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('s', $_GET["comment_id"]);
	$stmt->execute();
	$stmt->close();

	header("Location: individual_story.php?post_id=" . $_GET['post_id']);
	exit;
}
else {
	header("Location: main.php");
	exit;
}
?>