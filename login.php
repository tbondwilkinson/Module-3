<!DOCTYPE html>
<head>
	<title>Login</title>
</head>
<body>
	<h2>LOGIN</h2>
		<?php
			if (isset($_GET['attempts'])) {
				if (isset($_GET['username'])) {
					echo "Invalid username: " . $_GET['username'] . "<br>";
				}
				else {
					echo "Invalid username<br>";
				}
			}
			else {
				echo "<br>";
			}
		?>
	<form action="validate.php" method="post">
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