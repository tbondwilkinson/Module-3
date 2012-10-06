<?php
session_start();

// Unset the session variables and all session data associated with the user.
$_SESSION['logged_in'] = false;
unset($_SESSION['username']);
unset($_SESSION['token']);
header("Location: main.php");
exit;
?>