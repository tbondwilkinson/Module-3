<?php phpinfo(); ?>

<?php
$mysqli = new mysqli('localhost', 'php', 'php', 'module3');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>