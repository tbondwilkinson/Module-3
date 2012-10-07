<?php
require "database.php";
session_start();

// Display the story and all it's comments
if (isset($_GET['post_id'])) {
	$stmt = $mysqli->prepare("SELECT post_timestamp, post, post_id, username FROM posts WHERE post_id = ?");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('d', $_GET["post_id"]);
	$stmt->execute();
	$stmt->bind_result($post_timestamp, $post, $post_id, $username);
	$stmt->fetch();
	$stmt->close();

	// Display te story, who posted it, and when.
	printf("<pre>%s</pre>Posted by %s at %s<br>",
		htmlentities($post), 
		htmlentities($username), 
		htmlentities($post_timestamp)
	);

	// Display the add comment, delete, and edit links depending on the type of user.
	if($_SESSION['logged_in']) {
		echo "<a href=commententry.php?post_id=" . $post_id . ">Add a comment!</a><br>";
		if ($_SESSION['admin'] or $username == $_SESSION['username']) {
			echo "<a href=delete_post.php?post_id=" . $post_id . ">Delete</a><br>";
		}
		if ($username == $_SESSION['username']) {
			echo "<a href=edit_post.php?post_id=" . $post_id . ">Edit</a>";
		}
	}

	$stmt = $mysqli->prepare("SELECT comment_timestamp, comment, comment_id, username FROM comments WHERE post_id = ? ORDER BY comment_timestamp DESC");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('d', $_GET["post_id"]);
	$stmt->execute();
	$stmt->bind_result($comment_timestamp, $comment, $comment_id, $username);

	// Display each comment.
	echo "<ul>";
	while($stmt->fetch()){
		printf("<li><pre>%s</pre>Posted by %s at %s</li>\n", 
			htmlentities($comment),
			htmlentities($username), 
			htmlentities($comment_timestamp)
		);

		// Display the delete and edit buttons depending on the user.
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
}
else {
	header("Location: main.php");
	exit;
}
?>
<a href="main.php">Back to main board</a>