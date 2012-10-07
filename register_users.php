<?php
require "database.php";
session_start();

if (isset($_POST['username']) and isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
}
else {
	header("Location: add_users.php");
	exit;
}

// Check to see if we already have a username
$stmt = $mysqli->prepare("SELECT id, crypted_password FROM users WHERE username = ?");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($id, $crypted_password);

if ($stmt->fetch()) {
	header("Location: add_users.php?error=taken");
	exit;
}

$stmt->close();

// Insert a new username
$stmt = $mysqli->prepare("INSERT INTO users (username, crypted_password) VALUES (?, ?)");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ss', $username, crypt($password));
$stmt->execute();
$stmt->close();
header("Location: main.php");
exit;
?>