<!DOCTYPE html>
<head>
	<title>Login</title>
</head>
<body>
	<h2>LOGIN</h2>
		<?php
			if (isset($_GET['error'])) {
				if($_GET['error'] == "nousername") {
					echo "No such username (" . $_GET['username'] . ")<br>";
				}
				elseif ($_GET['error'] == "badpassword") {
					echo "Invalid password for username (" . $_GET['username'] . ")<br>";
				}
			}
			else {
				echo "<br>";
			}
		?>
	<form action="validate_users.php" method="post">
		<p>
			<label for="username">Username</label>
			<input type="text" name="username" id="username">
			<label for="password">Password</label>
			<input type="password" name="password" id="password">
		</p>
		<p>
			<input type="submit" value="Submit">
		</p>
	</form><br><br>
<a href="add_users.php">Add a new user</a>
</body>