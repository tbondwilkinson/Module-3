<?php
require "database.php";
session_start();

// Check to see whether the username exists.
if (isset($_POST['username']) and isset($_POST['password'])) {
	// Use a prepared statement
	$stmt = $mysqli->prepare("SELECT COUNT(*), id, crypted_password, administrator FROM users WHERE username=?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	// Bind the parameter
	$user = $_POST['username'];
	$stmt->bind_param('s', $user);
	$stmt->execute();
	 
	// Bind the results
	$stmt->bind_result($cnt, $user_id, $pwd_hash, $administrator);
	$stmt->fetch();
	 
	$pwd_guess = $_POST['password'];
	// Compare the submitted password to the actual password hash
	if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){
		// Login succeeded!
		$_SESSION['logged_in'] = true;
		$_SESSION['user_id'] = $user_id;
		$_SESSION['username'] = $user;
		$_SESSION['token'] = md5(uniqid(rand(), true));
		$_SESSION['admin'] = $administrator;
		header("Location: main.php");
		exit;
	}
	elseif ($cnt == 0) {
		header("Location: login.php?error=nousername&username=" . $_POST['username']);
		exit;
	}
	else{
		// Login failed; redirect back to the login screen
		header("Location: login.php?error=badpassword&username=" . $_POST['username']);
		exit;
	}
}

header("Location: login.php?attempts=1");
exit;
?>