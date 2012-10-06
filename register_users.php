<?php

session_start();

require "database.php";

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $mysqli->prepare("select id, crypted_password from users where username = ?");

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

$stmt = $mysqli->prepare("insert into users (username, crypted_password) values (?, ?)");

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