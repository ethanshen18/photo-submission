<?php

// delete image and thumbnail
unlink("uploads/" . $_GET["src"]);
unlink("thumbnails/thumb_" . $_GET["src"]);

// load json into array
$jsonArray = file("galleryinfo.json");
$jsonString = "";
foreach ($jsonArray as $line) $jsonString .= $line;
$phparray = json_decode($jsonString, true);

// delete image
for ($i = 0; $i < sizeof($phparray); $i++)
	if ($phparray [$i] ["fileToUpload"] == $_GET["src"]) 
		unset($phparray [$i]);

// reindex php array
$phparray = array_values($phparray);

// save new jason
file_put_contents("galleryinfo.json", json_encode($phparray, JSON_PRETTY_PRINT));

?>