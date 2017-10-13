<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
		<title>Upload Image</title>
		<link rel="shortcut icon" type="image/ico" href="images/upload.ico">
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
		<link rel="stylesheet" href="form.css">
	</head>

	<body ontouchstart>
		<div style="background: black"><a href="index.php" id="back-button">BACK</a></div>

		<div style="padding: 20px;">
			<?php echo "<img src='thumbnails/thumb_". $_GET['image'] ."'"; ?>
			<br><br><br>
			Your image has been uploaded successfully
			<br><br>
			It is pending approval from moderators
		</div>
	</body>
</html>