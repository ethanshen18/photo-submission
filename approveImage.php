<?php

// load json into array
$jsonArray = file("galleryinfo.json");
$jsonString = "";
foreach ($jsonArray as $line) $jsonString .= $line;
$phparray = json_decode($jsonString, true);

// approve image
for ($i = 0; $i < sizeof($phparray); $i++) {
	for ($j = 0; $j < sizeof($_GET["src"]); $j++) {
		if ($phparray [$i] ["fileToUpload"] == $_GET["src"] [$j]) 
		$phparray [$i] ["approved"] = true;
	} // for src
} // for phparray

// save new json
file_put_contents("galleryinfo.json", json_encode($phparray, JSON_PRETTY_PRINT));

?>