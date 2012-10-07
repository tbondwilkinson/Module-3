<?php

// Verify the user's token.
if ($_SESSION['token'] !== $_POST['token']) {
	header("Location: main.php?error=invalid_token");
	exit;
} 

$stmt = $mysqli->prepare("UPDATE posts SET post=? WHERE post_id = ?");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ss', $_POST['post'], $_POST["post_id"]);

$stmt->execute();
 
$stmt->close();

header("Location: main.php");
exit;
?>