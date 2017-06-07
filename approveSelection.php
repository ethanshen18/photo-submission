<?php

// load json into array
$jsonArray = file("galleryinfo.json");
$jsonString = "";
foreach ($jsonArray as $line) $jsonString .= $line;
$phparray = json_decode($jsonString, true);

// approve image
for ($i = 0; $i < sizeof($phparray); $i++)
	if ($phparray [$i] ["fileToUpload"] == $_GET["src"]) 
		$phparray [$i] ["approved"] = true;

// save new json
file_put_contents("galleryinfo.json", json_encode($phparray, JSON_PRETTY_PRINT));

?>