<?php
session_start();

require "database.php";

// Check to see whether the username exists.
if (isset($_POST['username']) and isset($_POST['password'])) {
	// Use a prepared statement
	$stmt = $mysqli->prepare("SELECT COUNT(*), id, crypted_password FROM users WHERE username=?");

	// Bind the parameter
	$user = $_POST['username'];
	$stmt->bind_param('s', $user);
	$stmt->execute();
	 
	// Bind the results
	$stmt->bind_result($cnt, $user_id, $pwd_hash);
	$stmt->fetch();
	 
	$pwd_guess = $_POST['password'];
	// Compare the submitted password to the actual password hash
	if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){
		// Login succeeded!
		$_SESSION['logged_in'] = true;
		$_SESSION['user_id'] = $user_id;
		$_SESSION['token'] = md5(uniqid(rand(), true));
		header("Location: main.php");
		exit;
	}else{
		// Login failed; redirect back to the login screen
		header("Location: login.php?attempts=1&username=" . $_POST['username'] . "&cnt=" . $cnt . "&pwd_hash=" . crypt($pwd_guess, $pwd_hash));
		exit;
	}
}

header("Location: login.php?attempts=1");
exit;
?>