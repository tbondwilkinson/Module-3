<?php
session_start();

require "database.php";

// Check to see whether the username exists.
if (isset($_POST['commententry'])) {
	$stmt = $mysqli->prepare("insert into comments (post_id, comment) values (?, ?)");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('s', $_GET['post_id'], $_POST['commententry']);

	$stmt->execute();
	 
	$stmt->close();
}

header("Location: main.php");
exit;
?>