<?php
require "database.php";
session_start();

$stmt = $mysqli->prepare("SELECT COUNT(*) FROM votes WHERE post_id = ? and username = ?");

$stmt->bind_param('ss', $_GET['post_id'], $_SESSION['username']);

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_result($count);

$stmt->execute();

$stmt->close();

if($count == 0) {

	$stmt = $mysqli->prepare("UPDATE posts SET votes=? WHERE post_id = ?");

	$stmt->bind_param('ss', $_GET['votes'] + 1, $_GET['post_id']);

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->execute();

	$stmt->close();

	$stmt = $mysqli->prepare("INSERT INTO votes (post_id, username) VALUES (?, ?)");

	$stmt->bind_param('ss', $_GET['post_id'], $_SESSION['username']);

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->execute();

	$stmt->close();
}

header("Location: main.php");
exit;
?>