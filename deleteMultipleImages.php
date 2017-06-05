<?php

unlink("uploads/" . $_GET["src"]);
unlink("thumbnails/thumb_" . $_GET["src"]);

// load json into array
$jsonArray = file("galleryinfo.json");
$jsonString = "";
foreach ($jsonArray as $line) $jsonString .= $line;
$phparray = json_decode($jsonString, true);

// delete image and thumbnail
// if(isset($_POST["delete"]) && $_POST["delete"] == "delete"){
		// if(!empty($_POST["checkBox"])){
			// foreach($_POST["checkBox"] as $img){
				// unlink("uploads/" . $img);
				// unlink("thumbnails/thumb_" . $img);
				// for ($i = 0; $i < sizeof($phparray); $i++){
					// if ($phparray [$i] ["fileToUpload"] == $img) 
					// unset($phparray [$i]);
				// } // for
			// } // foreach
		// } // if
// } else {

	

// delete image
for ($i = 0; $i < sizeof($phparray); $i++)
	if ($phparray [$i] ["fileToUpload"] == $_GET["src"]) 
		unset($phparray [$i]);	
// } // if

// reindex php array
$phparray = array_values($phparray);

// save new jason
file_put_contents("galleryinfo.json", json_encode($phparray, JSON_PRETTY_PRINT));

?>