<!DOCTYPE html>
<head>
<link rel="stylesheet" href="style.css" type="text/css">
<title>Add a new story!</title>
</head>
<body>
<form action="submit_story.php" method="POST">
<textarea rows="10" cols="50" placeholder="Enter your story here" name="storyentry" id="storyentry">
</textarea>
<input type="hidden" name="token" value="<?=$_SESSION['token'];?>" />
<input type="submit" value="Submit!">
</form>
</body>
</html>
