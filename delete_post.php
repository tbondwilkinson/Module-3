<?php

session_start();

require "database.php";

if (isset($_GET["post_id"])) {

	$stmt1 = $mysqli->prepare("DELETE FROM comments WHERE post_id = ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt1->bind_param('s', $_GET["post_id"]);

	$stmt1->execute();
	 
	$stmt1->close();

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

?>