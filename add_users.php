<!DOCTYPE html>
<head>
<link rel="stylesheet" href="style.css" type="text/css">
<title>Register As a New User!</title>
</head>
<body>
<?php
// If the username is already taken, register.php
// will send the user back to this page with an error.
if (isset($_GET['error'])) {
  if ($_GET['error'] == "taken") {
    echo "That username is taken.";
  }
}
?>
<form action="register_users.php" method="POST">
Username: <input type="text" name="username"><br>
Password: <input type="text" name="password">
<input type="submit" value="Create!">
</form>
</body>
</html>
