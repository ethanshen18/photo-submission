<?php

// load json into array
$jsonArray = file("galleryinfo.json");
$jsonString = "";
foreach ($jsonArray as $line) $jsonString .= $line;
$phparray = json_decode($jsonString, true);

// get size of phparray
$arraysize = sizeof($phparray);

// modify info
for ($i = 0; $i < $arraysize; $i++) {
	if ($phparray [$i] ["fileToUpload"] == $_GET["target"]) {
		$phparray [$i] ["firstName"] = $_GET["firstName"];
		$phparray [$i] ["lastName"] = $_GET["lastName"];
		$phparray [$i] ["description"] = $_GET["description"];
		$phparray [$i] ["tags"] = $_GET["tags"];
	} // if
} // for phparray

// save new json
file_put_contents("galleryinfo.json", json_encode($phparray, JSON_PRETTY_PRINT));

?>