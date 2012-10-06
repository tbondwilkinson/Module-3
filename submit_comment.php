<?php
session_start();

require "database.php";

// Verify the user's token.
if ($_SESSION['token'] !== $_POST['token']) {
	echo $_SESSION['token'];
	echo $_POST['token'];
	//header("Location: main.php?error=invalid_token");
	exit;
} 

// Check to see whether the username exists.
if (isset($_POST['commententry'])) {
	$stmt = $mysqli->prepare("insert into comments (post_id, comment, username) values (?, ?, ?)");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('ds', $_GET['post_id'], $_POST['commententry'], $_SESSION['username']);

	$stmt->execute();
	 
	$stmt->close();
}
else {
	echo "Comment entry not set";
}

header("Location: main.php");
exit;
?>