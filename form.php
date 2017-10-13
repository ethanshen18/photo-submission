<?php

// user info
$firstName = "";
$lastName = "";
$description = "";
$copyright = "";
$access = "";

// button values
$submit = "";
$view = "";

// error messages
$firstNameError = "";
$lastNameError = "";
$fileError = "";
$descriptionError = "";
$copyrightError = "";
$accessError = "";

// functions file
include 'functions.php';

// update submit
if (!empty($_POST["submit"])) $submit = ($_POST["submit"]);
else if (!empty($_POST["view"])) $view = ($_POST["view"]);

// submit form
if ($submit == "submit") {

	// test inputs and display error messages
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// first name
		if (empty($_POST["firstName"])) {
			$firstNameError = "required";
			echo "<style> #first-name::-webkit-input-placeholder {color: red;} </style>";
		} else $firstName = cleanData($_POST["firstName"]);

		// last name
		if (empty($_POST["lastName"])) {
			$lastNameError = "required";
			echo "<style> #last-name::-webkit-input-placeholder {color: red;} </style>";
		} else $lastName = cleanData($_POST["lastName"]);

		// image
		$newFileName = uniqid();
		$fileError = processImage($newFileName);
		$newFileName .= "." . pathinfo("uploads/" . basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION);

		// description
		if (empty($_POST["description"])) {
			$descriptionError = "required";
			echo "<style> #description::-webkit-input-placeholder {color: red;} </style>";
		} else $description = cleanData($_POST["description"]);

		// copyright
		if (empty($_POST["copyright"])) $copyrightError = "required";
		else $copyright = cleanData($_POST["copyright"]);

		// access
		if (empty($_POST["access"])) $accessError = "required";
		else $access = cleanData($_POST["access"]);
	} // if

	// process user info if no error detected
	if ($firstNameError == null && $lastNameError == null && $fileError == null && $descriptionError == null && $copyrightError == null && $accessError == null) {

		newSubmission($firstName, $lastName, $newFileName, $description, $copyright, $access);
		header('Location: message.php?image='.$newFileName);

	// display form if error detected
	} else include 'form.inc';

// view album
} else if ($view == "view"){

	// back to home page
	header('Location: index.php');

// display form if no button clicked
} else include 'form.inc';

?>