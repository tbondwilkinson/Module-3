<?php

session_start();

require "database.php";

if (isset($_GET["comment_id"])) {

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

?>