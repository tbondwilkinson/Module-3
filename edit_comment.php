<?php

session_start();

require "database.php";

if (isset($_GET["comment_id"])) {

	$stmt = $mysqli->prepare("SELECT comment FROM comments WHERE comment_id = ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('s', $_GET["comment_id"]);

	$stmt->execute();

	$stmt->bind_result($comment);

	$stmt->fetch();
	 
	$stmt->close();
?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" href="style.css" type="text/css">
<title>Edit a Comment</title>
</head>
<body>
<form action="submit_edit_comment.php" method="POST">
<textarea rows="10" cols="50" name="comment" id="comment">
<?=$comment;?>
</textarea><br>
<input type="hidden" name="token" value="<?=$_SESSION['token'];?>" />
<input type="hidden" name="comment_id" id="comment_id" value="<?=$_GET['comment_id'];?>" />
<input type="submit" value="Submit!">
</form>
</body>
</head>
</html>
