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


		<form method="post"  enctype="multipart/form-data">
			<h1 id="submission-text">SUBMISSION</h1>

			<fieldset>
				<legend>Basic Info</legend>

				<input type="text" name="firstName" id="first-name" maxlength="20" placeholder="first name <?php echo $firstNameError;?>" value="<?php echo $firstName;?>">

				<input type="text" name="lastName" id="last-name" maxlength="20" placeholder="last name <?php echo $lastNameError;?>" value="<?php echo $lastName;?>">
			</fieldset>

			<fieldset>
				<legend>Upload 
				<?php if ($fileError != "") echo "<span class='error'>$fileError</span>"; ?>
				</legend>

				<div id="file-input-wrapper">
					<input type="file" name="fileToUpload" id="fileToUpload" style="z-index: 1">
					<button href="#" id="upload-button"><span>SELECT IMAGE</span></button>
				</div>
			</fieldset>

			<fieldset>
				<legend>Description</legend>
		      
				<textarea name="description" id="description" maxlength="120" placeholder="120 characters max <?php echo $descriptionError;?>"><?php echo $description;?></textarea>
			</fieldset>

			<fieldset>
				<legend>Copyright 
				<?php if ($copyrightError != "") echo "<span class='error'>$copyrightError</span>"; ?>
				</legend>

				<div id="checkbox-container"><input type="checkbox" name="copyright" class="checkbox" <?php if (isset($copyright) && $copyright=="on") echo "checked";?>></div>
				<div id="copyright">I retain the copyright to this image and release it for use on this site</div>
			</fieldset>

			<fieldset>
				<legend>Access 
				<?php if ($accessError != "") echo "<span class='error'>$accessError</span>"; ?>
				</legend>

				<span>
					<input type="radio" value="public" name="access" id="radio1" class="radio" <?php if (isset($access) && $access=="public") echo "checked";?>>
					<label for="radio1" class="radio-text">Public</label>
				</span>

				<span>
					<input type="radio" value="private" name="access" id="radio2" class="radio" <?php if (isset($access) && $access=="private") echo "checked";?>>
					<label for="radio2" class="radio-text">Private</label>
				</span>
			</fieldset>

			<div>
				<button type="submit" name="submit" value="submit" id="submit-button" class="form-buttons">SUBMIT</button>
				<button type="view" name="view" value="view" id="view-button" class="form-buttons">CANCEL</button>
				<button type="reset" name="reset" value="reset" id="reset-button" class="form-buttons">RESET</button>
			</div>
		</form>

		<script src="form.js"></script>
	</body>
</html>