<?php

session_start();

require "database.php";

if (isset($_GET["post_id"])) {
	$stmt = $mysqli->prepare("DELETE FROM posts WHERE post_id = ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('s', $_GET["post_id"]);

	$stmt->execute();
	 
	$stmt->close();

	$stmt1 = $mysqli->prepare("DELETE FROM comments WHERE post_id = ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt1->bind_param('s', $_GET["post_id"]);

	$stmt1->execute();
	 
	$stmt1->close();

	header("Location: main.php");

	exit;
}

?>