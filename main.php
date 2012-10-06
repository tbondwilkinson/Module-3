<?php
session_start();

// Take the user to the login screen if the user has yet to log in.
if (!$_SESSION['logged_in']) {
	header("Location: login.php");
	exit;
}
?>
<!DOCTYPE html>
<head>
	<title>Welcome!</title>
</head>
<body>
	IT WORKS!  AND IT IS COOL!
	<div id="fupload-logout">
  		<form action="logout_users.php" method="POST">
    		<input type="submit" value="Logout">
  		</form>
	</div>
</body>