<?php
require "database.php";
session_start();

// Check to see if this user has already voted for this post
$stmt = $mysqli->prepare("SELECT COUNT(*) FROM votes WHERE post_id = ? and username = ?");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ss', $_GET['post_id'], $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if($count == 0 and isset($_GET['post_id']) and isset($_GET['votes'])) {

	// Increment the number of votes for this post by 1
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

	// Insert the vote associated with this user into the table
	$stmt = $mysqli->prepare("INSERT INTO votes (post_id, username) VALUES (?, ?)");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('ss', $_GET['post_id'], $_SESSION['username']);
	$stmt->execute();
	$stmt->close();
}

header("Location: main.php");
exit;
?>