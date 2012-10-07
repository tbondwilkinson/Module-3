<?php

session_start();

require "database.php";

if (isset($_GET["post_id"])) {

	$stmt = $mysqli->prepare("SELECT post FROM posts WHERE post_id = ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('s', $_GET["post_id"]);

	$stmt->execute();

	$stmt->bind_result($post);
	$stmt->fetch();
	 
	$stmt->close();
}
?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" href="style.css" type="text/css">
<title>Add a new comment!</title>
</head>
<body>
<form action="edit_post_submit.php" method="POST">
<textarea rows="10" cols="50" name="post" id="post">
<?=$post;?>
</textarea>
<input type="hidden" name="token" value="<?=$_SESSION['token'];?>" />
<input type="hidden" name="post_id" value="<?=$_GET['post_id'];?>" />
<input type="submit" value="Submit!">
</form>
</body>
</head>
</html>