<?php

// clean input data
function cleanData($data) {
	$data = trim($data);
	$data = strip_tags($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
} // cleanData

// new image submission
function newSubmission($firstName, $lastName, $fileToUpload, $description, $tag, $copyright, $access) {
	$jsonArray = file("galleryinfo.json");
	$jsonString = "";
	foreach ($jsonArray as $line) $jsonString .= $line;
	$phparray = json_decode($jsonString, true);
	$phparray[] = array("firstName" => $firstName, "lastName" => $lastName, "fileToUpload"=> $fileToUpload, "description" => $description, "tags" => $tag, "copyright" => $copyright, "access" => $access, "approved" => false);
	file_put_contents("galleryinfo.json", json_encode($phparray, JSON_PRETTY_PRINT));
} // newSubmission

// display all users
function showUsers() {
	echo "<pre>";
		$jsonArray = file("galleryinfo.json");
		$jsonstring = "";
		foreach ($jsonArray as $line) $jsonstring .= $line;
		var_dump(json_decode($jsonstring, true));
	echo "</pre>";
} // showUser

// display all images
function showImages() {
	$dir = "uploads/";
	if (is_dir($dir) && $dh = opendir($dir)){
		while (($file = readdir($dh)) !== false) {
			if (pathinfo($dir . $file, PATHINFO_EXTENSION) == "png" || 
				pathinfo($dir . $file, PATHINFO_EXTENSION) == "jpg" || 
				pathinfo($dir . $file, PATHINFO_EXTENSION) == "jpeg") 
				echo $file . "<img src = " . $dir . $file . ">";
		} // while
		closedir($dh);
	} // if
} // showImages

// process user upload
function processImage($id) {
	$dir = "uploads/";
	$uploadOk = 1;
	$type = pathinfo($dir . basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION);
	$fileError = "";

	if ($_FILES["fileToUpload"]["size"] > 2000000) {
		$fileError = "File exceeds 2MB";
		$uploadOk = 0;
	} else if ($type != "jpg" && $type != "png" && $type != "jpeg") {
		$fileError = "JPG & PNG files only";
		if ($type == null) $fileError = "required";
		$uploadOk = 0;
	} else {
		if (getimagesize($_FILES["fileToUpload"]["tmp_name"]) === false) {
			$fileError = "File error or size exceeds 2MB";
			$uploadOk = 0;
		} // if
	} // if else

	if ($uploadOk == 1) {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $dir . $id . '.' . $type)) {
			createThumb("uploads/", $id . "." . $type);
			header("Location: index.php");
		} else {
			echo "Sorry, there was an error uploading your file.";
		} // if else
	} // if else

	return $fileError;
} // processImage

function createThumb($dir, $name) {
	$thumbSize = 300;
	$file = $dir . $name;

	// calculate width and height
	list($width, $height) = getimagesize($file);
	if ($width > $thumbSize && $height > $thumbSize) {
		if ($width > $height) {
			$newWidth = $thumbSize;
			$newHeight = $height / $width * $thumbSize;
		} else {
			$newWidth = $width / $height * $thumbSize;
			$newHeight = $thumbSize;
		} // if else

		// determine file type
		if (!($src = imagecreatefromjpeg($file))) $src = imagecreatefrompng($file);

		// create new image
		$dst = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresized($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

		// save as thumbnail
		imagejpeg($dst, "thumbnails/thumb_" . $name);
		imagedestroy($dst);
	} // crop if too large
} // createThumb

// show all thumbnails from folder
function displayThumbnails($sort, $search, $display, $isEditor, $view) {

	// display result sorting type
	if (!empty($sort)) echo "Sort by: " . $sort . "<br>";
	if (!empty($display) && $isEditor) echo "Access: " . $display . "<br>";
	if (!empty($search)) echo "Results for: " . $search . "<br>";

	// load json into array
	$jsonArray = file("galleryinfo.json");
	$jsonString = "";
	foreach ($jsonArray as $line) $jsonString .= $line;
	$phparray = json_decode($jsonString, true);

	// sort thumbnails
	if ($sort == "firstName") usort($phparray, function($x, $y) {
		return strcasecmp($x["firstName"], $y["firstName"]);
	}); else if ($sort == "lastName") usort($phparray, function($x, $y) {
		return strcasecmp($x["lastName"], $y["lastName"]);
	});

	// duplicate array
	$phparraySorted = array_values($phparray);

	// filter search results and restrictions
	for ($i = 0; $i < sizeof($phparray); $i++) {

		// get info from json file
		$access = $phparraySorted [$i] ["access"];
		$tags = trim ($phparraySorted [$i] ["tags"], " ");
		$approved = $phparraySorted [$i] ["approved"];

		// check if photo is approved
		if (!$isEditor && !$approved) {
			unset($phparraySorted [$i]);
			continue;
		} else if ($isEditor && $view == "edit" && !$approved) {
			unset($phparraySorted [$i]);
			continue;
		} else if ($isEditor && $view == "approval" && $approved) {
			unset($phparraySorted [$i]);
			continue;
		} // if else
		
		// seperate tags by comma
		$tagCheck = explode(",", $tags);
		
		// trim spaces in the beginning and end of tags
		for ($j = 0; $j < sizeof($tagCheck); $j++){
			$tagCheck[$j] = trim($tagCheck[$j], " ");
		} // for
		
		// check photo access and search results
		if (!empty($display) && $access != $display) {
			unset($phparraySorted [$i]);
		} else if (!empty($search) && !in_array($search, $tagCheck)) {
			unset($phparraySorted [$i]);
		} // if
		
	} // for

	// reindex array
	$phparraySorted = array_values($phparraySorted);
	
	// display editor buttons and messages
	if ($isEditor) editorNavbar($view);

	// transfer current gallery content as json array to javascript
	echo "<pre id='current-array' style='display: none'>";
	echo json_encode($phparraySorted, JSON_PRETTY_PRINT);
	echo "</pre>";

	// go through json file
	for ($i = 0; $i < sizeof($phparraySorted); $i++) {

		// get info from json file
		$firstName = $phparraySorted [$i] ["firstName"];
		$lastName = $phparraySorted [$i] ["lastName"];
		$description = $phparraySorted [$i] ["description"];
		$original = $phparraySorted [$i] ["fileToUpload"];
		$tags = $phparraySorted [$i] ["tags"];

		// generate bootstrap grid
		if ($isEditor && $view == "edit") editMode($original, "thumbnails/thumb_" . $original, $firstName, $lastName, $description, $tags);
		else if ($isEditor && $view == "approval") approvalMode($original, "thumbnails/thumb_" . $original, $firstName, $lastName, $description, $tags);
		else publicGallery($original, "thumbnails/thumb_" . $original, $firstName, $lastName, $description);
	} // for
} // displayThumbnails

// generate public gallery
function publicGallery($original, $thumbName, $firstName, $lastName, $description) {
	echo "<div class=\"col-sm-3\">
			<div class=\"grid-container\" onclick=\"showLightbox('". $original ."', '". $firstName ."', '". $lastName ."', '". $description ."')\">
				<div class=\"public-photo-container\"><img src=\"". $thumbName ."\" class=\"photo\"></div>
				<div class=\"text\">". $firstName ." ". $lastName ."</div>
			</div>
		</div>";
} // publicGallery

// show editor buttons and messages
function editorNavbar($view) {
	
	// Editor View
	if ($view == "edit") echo "<h3><i class=\"glyphicon glyphicon-pencil\"></i> Edit Mode</h3><br><br>";
	if ($view == "approval") echo "<h3><i class=\"glyphicon glyphicon-inbox\"></i> Waiting For Approval</h3><br><br>";

	// button section
	echo "<div id=\"button-container\">";

	// edit view
	if ($view == "edit") {

		// waiting for approval button
		echo "<a href=\"#\" onclick=\"addToURL('view', 'approval'); return false;\" class=\"btn btn-success\" role=\"button\" id=\"waiting-for-approval-button\"><i class=\"glyphicon glyphicon-inbox\"></i> Waiting For Approval</a>";

	// approval view
	} else if ($view == "approval") {

		// edit button
		echo "<a href=\"#\" onclick=\"addToURL('view', 'edit'); return false;\" class=\"btn btn-success\" role=\"button\" id=\"edit-view-button\"><i class=\"glyphicon glyphicon-pencil\"></i> Edit Approved Images</a>";
	} // if else

	// download all button
	echo "<a href=\"downloadAll.php\" class=\"btn btn-success\" role=\"button\" id=\"download-all-button\"><i class=\"glyphicon glyphicon-download-alt\"></i> Download All</a>";

	// end button section
	echo "</div>";
} // editorNavbar

// generate editor gallery
function editMode($original, $thumbName, $firstName, $lastName, $description, $tags) {
	echo "<div class='editor-grid' value='". $original ."'>
			<div class='col-sm-4' style=\"padding: 10px\">
				<div class=\"edit-photo-container\" name=\"checkBox\">
					<input type=\"checkbox\" id=\"image-checkbox-". $original ."\" class=\"check\" onclick=\"selected()\" value=\"". $original ."\">
					<label for=\"image-checkbox-". $original ."\"><img src=\"". $thumbName ."\" class=\"edit-photo\"></label>
				</div>
			</div>
			<div class='col-sm-8'>
				<div class='editor-view-name'>
					<b>First Name: </b>
					<input type='text' id='". $original ."-firstName' autocomplete='off' autocorrect='off' autocapitalize='off' spellcheck='false' value='". $firstName ."' disabled='' class='". $original ."'></input>
				</div>
				<div class='editor-view-name'>
					<b>Last Name: </b>
					<input type='text' id='". $original ."-lastName' autocomplete='off' autocorrect='off' autocapitalize='off' spellcheck='false' value='". $lastName ."' disabled='' class='". $original ."'></input>
				</div>
				<br>
				<b>Description: </b><br>
					<textarea id='". $original ."-description' autocomplete='off' autocorrect='off' autocapitalize='off' spellcheck='false' disabled='' class='". $original ."'>". $description ."</textarea><br>
				<b>Tags: </b><br>
					<textarea id='". $original ."-tags' autocomplete='off' autocorrect='off' autocapitalize='off' spellcheck='false' disabled='' class='". $original ."'>". $tags ."</textarea>

				<div class=\"btn-group btn-group-justified\"  role=\"group\" aria-label=\"...\" style=\"margin: 10px 0\" value='".$original."'>
					<div class=\"btn-group\" role=\"group\">
						<button class=\"btn btn-success\" style=\"padding: 0\"><a class=\"download-button\" href=\"uploads/". $original ."\" download=\"". $firstName ." ". $lastName ."\"><i class=\"glyphicon glyphicon-download-alt\"></i></a></button>
					</div>
					<div class=\"btn-group\" role=\"group\">
						<button class=\"btn btn-default\" onclick=\"editInfo('". $original ."');\"><i class=\"glyphicon glyphicon-pencil\"></i></button>
					</div>
					<div class=\"btn-group\" role=\"group\">
						<button class=\"btn btn-default\" onclick=\"showLightbox('". $original ."', '". $firstName ."', '". $lastName ."', '". $description ."')\"><i class=\"glyphicon glyphicon-picture\"></i></button>
					</div>
					<div class=\"btn-group\" role=\"group\">
						<button class=\"btn btn-danger\" onclick=\"deleteImage('". $original ."')\"><i class=\"glyphicon glyphicon-trash\"></i></button>
					</div>
				</div>
				
				<button class =\"btn btn-success btn-block\" style=\"display: none; margin: 10px 0;\" onclick=\"save('". $original ."');\" >Save</button>
			</div>
		</div>";
} // editorGallery

// generate editor gallery
function approvalMode($original, $thumbName, $firstName, $lastName, $description, $tags) {
	echo "<div class=\"col-sm-3\">
			<div class=\"approve-container\" name=\"checkBox\">
				<div class=\"approve-photo-container\">
					<input type=\"checkbox\" id=\"image-checkbox-". $original ."\" class = \"check\" onclick=\"selected()\" value=\"". $original ."\">
					<label for=\"image-checkbox-". $original ."\"><img src=\"". $thumbName ."\" class=\"approve-photo\"></label>
				</div>

				<div class=\"approval-info\" style=\"border: 1px solid transparent\">
					<div class=\"text\"><b>Name: </b>". $firstName ." ". $lastName ."</div>
					<div class=\"text\"><b>Description: </b>". $description ."</div>
					<div class=\"text\"><b>Tags: </b>". $tags ."</div>
				</div>

				<div class=\"btn-group btn-group-justified\" role=\"group\" aria-label=\"...\">
					<div class=\"btn-group\" role=\"group\">
						<button class=\"btn btn-success\" onclick=\"approveImage('". $original ."')\"><i class=\"glyphicon glyphicon-ok\"></i></button>
					</div>
					<div class=\"btn-group\" role=\"group\">
						<button class=\"btn btn-default\" onclick=\"showLightbox('". $original ."', '". $firstName ."', '". $lastName ."', '". $description ."')\"><i class=\"glyphicon glyphicon-picture\"></i></button>
					</div>
					<div class=\"btn-group\" role=\"group\">
						<button class=\"btn btn-danger\" onclick=\"deleteImage('". $original ."')\"><i class=\"glyphicon glyphicon-remove\"></i></button>
					</div>
				</div>
			</div>
		</div>";
} // editorGallery

?>