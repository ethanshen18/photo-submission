<?php

// photo directory
$pathdir = "uploads/";

// zip folder
$filename  = "baby-photo-gallery.zip";
$zip = new ZipArchive();

// zip archive
$zip->open($filename , ZIPARCHIVE::OVERWRITE | ZipArchive::CREATE);

// read directory
$dir = opendir($pathdir);
while ($file = readdir($dir)){
	$path = $pathdir.$file;
	if($file !== "." && $file !== "..")
	$zip->addFile($path, $file);
} // while

// finish zipping
$zip->close();

// send the file to the browser as a download
header("Content-Disposition: attachment; filename=\"". $filename ."\"");
header('Content-type: application/zip');
readfile($filename);

// remove server file
unlink($filename);

?>