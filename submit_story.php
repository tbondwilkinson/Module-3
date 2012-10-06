<?php
session_start();

require "database.php";

// Check to see whether the username exists.
if (isset($_POST['storyentry'])) {
	$stmt = $mysqli->prepare("insert into posts (post) values (?)");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('s', $_POST['storyentry']);

	$stmt->execute();
	 
	$stmt->close();
}

header("Location: main.php");
exit;
?>