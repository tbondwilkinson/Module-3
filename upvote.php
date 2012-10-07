<?php
require "database.php";
session_start();

$stmt = $mysqli->prepare("SELECT COUNT(*) FROM votes WHERE post_id = ? and username = ?");

$stmt->bind_param('ss', $_GET['post_id'], $_SESSION['username']);

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($count);

$stmt->fetch();

$stmt->close();

echo $count;

exit;

if($count == 0) {

	$stmt = $mysqli->prepare("UPDATE posts SET votes=? WHERE post_id = ?");

	$vote_num = $_GET['votes'];
	$vote_num += 1;

	$stmt->bind_param('ss', $vote_num, $_GET['post_id']);

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