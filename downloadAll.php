<?php

$pathdir = "uploads/";
$src = $_GET["src"];

$x = getenv("HOMEDRIVE") . getenv("HOMEPATH");
$zipname = $x."\Downloads\images.zip";
$zip = new ZipArchive;

if ($zip->open($zipname, ZIPARCHIVE::OVERWRITE | ZipArchive::CREATE) == true){
	$dir = opendir($pathdir);
	while($file = readdir($dir)){
		for($i = 0; $i < sizeof($src); $i++){
			if($src[$i] == $file){
				$zip->addFile($pathdir.$file, $file);
			} // if
		} // for
	} // while
	
	$zip->close();
	echo "Archive Saved in ".$x."\Downloads";
	
	// // http headers for zip downloads
	// header("Pragma: public");
	// header("Expires: 0");
	// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	// header("Cache-Control: public");
	// header("Content-Description: File Transfer");
	// header("Content-type: application/octet-stream");
	// header("Content-Disposition: attachment; zipname=\"".$zipname."\"");
	// header("Content-Transfer-Encoding: binary");
	// ob_end_flush();
	// @readfile($filepath.$zipname);
} else {
	echo "Download Failed!";
} // if



?>