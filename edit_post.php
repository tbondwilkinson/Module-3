<?php

session_start();

require "database.php";

if (isset($_GET["post_id"])) {

	$stmt = $mysqli->prepare("SELECT post FROM posts WHERE post_id = ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('s', $_GET["post_id"]);

	$stmt->execute();

	$stmt->bind_result($post);
	$stmt->fetch();
	 
	$stmt->close();

	$stmt = $mysqli->prepare("UPDATE posts SET post=? WHERE post_id = ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('ss', $post, $_GET["post_id"]);

	$stmt->execute();
	 
	$stmt->close();

	header("Location: main.php");

	exit;
}
?>