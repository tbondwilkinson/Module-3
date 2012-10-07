<?php
session_start();

// Unset the session variables and all session data associated with the user.
$_SESSION['logged_in'] = false;
unset($_SESSION['username']);
unset($_SESSION['user_id']);
unset($_SESSION['token']);
unset($_SESSION['admin']);
header("Location: main.php");
exit;
?>