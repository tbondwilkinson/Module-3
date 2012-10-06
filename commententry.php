<?php
session_start();
?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" href="style.css" type="text/css">
<title>Add a new comment!</title>
</head>
<body>
<form action="submit_comment.php?post_id=<?=$_GET['post_id']; ?>" method="POST">
<textarea rows="10" cols="50" placeholder="Enter your comment here" name="commententry" id="commententry">
</textarea>
<input type="hidden" name="token" value="<?=$_SESSION['token'];?>" />
<input type="submit" value="Submit!">
</form>
</body>
</html>