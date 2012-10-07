<?php
session_start();

require "database.php";

$stmt = $mysqli->prepare("SELECT post_timestamp, post, post_id, username FROM posts WHERE post_id = ?");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('d', $_GET["post_id"]);

$stmt->execute();

$stmt->bind_result($post_timestamp, $post, $post_id, $username);

$stmt->fetch();

printf("<pre>%s</pre>Posted by %s at %s<br>",
	htmlentities($post), 
	htmlentities($username), 
	htmlentities($post_timestamp)
);

if($_SESSION['logged_in']) {
	echo "<a href=commententry.php?post_id=" . $post_id . ">Add a comment!</a><br>";
	if ($_SESSION['admin'] or $username == $_SESSION['username']) {
		echo "<a href=delete_post.php?post_id=" . $post_id . ">Delete</a><br>";
	}
	if ($username == $_SESSION['username']) {
		echo "<a href=edit_post.php?post_id=" . $post_id . ">Edit</a>";
	}
}

$stmt->close();

$stmt = $mysqli->prepare("SELECT comment_timestamp, comment, comment_id, username FROM comments WHERE post_id = ? ORDER BY comment_timestamp DESC");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('d', $_GET["post_id"]);

$stmt->execute();

$stmt->bind_result($comment_timestamp, $comment, $comment_id, $username);

echo "<ul>";
while($stmt->fetch()){
	printf("<li><pre>%s</pre>Posted by %s at %s</li>\n", 
		htmlentities($comment),
		htmlentities($username), 
		htmlentities($comment_timestamp));

	if ($_SESSION['logged_in']) {
		if ($_SESSION['admin'] or $username == $_SESSION['username']) {
			echo "<a href=delete_comment.php?comment_id=" . $comment_id . "&post_id=" . $post_id . ">Delete</a><br>";
		}
		if ($username == $_SESSION['username']) {
			echo "<a href=edit_comment.php?comment_id=" . $comment_id . "&post_id=" . $post_id . ">Edit</a>";
		}
	}
}
echo "</ul></li>\n";

$stmt->close();
?>
<a href="main.php">Back to main board</a>