<?php

$pathdir = "uploads/";

//$x = getenv("HOMEDRIVE") . getenv("HOMEPATH");
$zipname = "images.zip";
$zip = new ZipArchive();

if ($zip->open($zipname, ZIPARCHIVE::OVERWRITE | ZipArchive::CREATE) == true){
	
	$dir = opendir($pathdir);
	while ($file = readdir($dir)){
		$path = $pathdir.$file;
		if($file !== "." && $file !== "..")
		$zip->addFile($path, $file);
	} // while
	
	$zip->close();

    # send the file to the browser as a download
    header('Content-disposition: attachment; filename=images.zip');
    header('Content-type: application/zip');
    readfile($zipname);
	
	// $path = $pathdir.$file;
	// $dir = opendir($pathdir);
	// while($file = readdir($dir)){
		// $zip->addFile($pathdir.$file, $file);
	// } // while
	
	// $zip->close();
	
	// http headers for zip downloads
	// header("Pragma: public");
	// header("Expires: 0");
	// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	// header("Cache-Control: public");
	// header("Content-Description: File Transfer");
	// header("Content-type: application/octet-stream");
	// header("Content-Disposition: attachment; zipname=\"".$zipname."\"");
	// header("Content-Transfer-Encoding: binary");
	// readfile($zipname);
	// exit;
	
	// $files = array('Dear GP.docx','ecommerce.doc');

    // # create new zip opbject
    // $zip = new ZipArchive();

    // # create a temp file & open it
    // $tmp_file = tempnam('.','');
    // $zip->open($tmp_file, ZipArchive::CREATE);

    // # loop through each file
    // foreach($files as $file){

        // # download file
        // $download_file = file_get_contents($file);

        // #add it to the zip
        // $zip->addFromString(basename($file),$download_file);

    // }

    // # close zip
    // $zip->close();

    // # send the file to the browser as a download
    // header('Content-disposition: attachment; filename=Resumes.zip');
    // header('Content-type: application/zip');
    // readfile($tmp_file);
} else {

} // if



?>