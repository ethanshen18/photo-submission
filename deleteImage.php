<?php

unlink("uploads/" . $_GET["src"]);
unlink("thumbnails/thumb_" . $_GET["src"]);

// load json into array
$jsonArray = file("galleryinfo.json");
$jsonString = "";
foreach ($jsonArray as $line) $jsonString .= $line;
$phparray = json_decode($jsonString, true);	

// delete image
for ($i = 0; $i < sizeof($phparray); $i++) {
	for ($j = 0; $j < sizeof($_GET["src"]); $j++) {
		if ($phparray [$i] ["fileToUpload"] == $_GET["src"] [$j]) {
			unset($phparray [$i]);
			unlink("uploads/" . $_GET["src"] [$j]);
			unlink("thumbnails/thumb_" . $_GET["src"] [$j]);
		} // if
	} // for src
} // for phparray

// reindex php array
$phparray = array_values($phparray);

// save new jason
file_put_contents("galleryinfo.json", json_encode($phparray, JSON_PRETTY_PRINT));

?>