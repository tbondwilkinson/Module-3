<?php

session_start();

require "database.php";

if (isset($_GET["comment_id"])) {

	$stmt = $mysqli->prepare("SELECT comment FROM commentss WHERE comment_id = ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('s', $_GET["comment_id"]);

	$stmt->execute();

	$stmt->bind_result($comment);
	$stmt->fetch();
	 
	$stmt->close();

	$stmt = $mysqli->prepare("UPDATE comments SET comment=? WHERE comment_id = ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('ss', $comment, $_GET["comment_id"]);

	$stmt->execute();
	 
	$stmt->close();

	header("Location: main.php");

	exit;
}
?>