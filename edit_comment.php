<?php
require "database.php";
session_start();

if (isset($_GET["comment_id"])) {
	// Fetch the comment text so that it shows up in the editing box.
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
}
else {
	header("Location: main.php");
	exit;
}
?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" href="style.css" type="text/css">
<title>Edit a Comment</title>
</head>
<body>
<form action="edit_comment_submit.php" method="POST">
<textarea rows="10" cols="50" name="comment" id="comment">
<?=$comment;?>
</textarea><br>
<input type="hidden" name="token" value="<?=$_SESSION['token'];?>" />
<input type="hidden" name="comment_id" id="comment_id" value="<?=$_GET['comment_id'];?>" />
<input type="hidden" name="post_id" id="post_id" value="<?=$_GET['post_id'];?>" />
<input type="submit" value="Submit!">
</form>
</body>
</head>
</html>