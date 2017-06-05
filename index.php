<?php

// new session
session_start();
$isEditor = true;

// URL variables
$sort = "";
$search = "";
$display = "";

// editor view
$view = "edit";

// functions file
include "functions.php";

// display header
include "gallery.inc";

// update search parameter
if (!empty($_POST["submit"]) && $_POST["submit"] == "submit" && !empty($_POST["search"])) $search = strtolower(cleanData($_POST["search"]));

// update sorting type
if (!empty($_GET["sort"]) && cleanData($_GET["sort"]) == "firstName") $sort = "firstName";
if (!empty($_GET["sort"]) && cleanData($_GET["sort"]) == "lastName") $sort = "lastName";

// update display type
if ($isEditor) {
	if (!empty($_GET["display"]) && cleanData($_GET["display"]) == "public") $display = "public";
	if (!empty($_GET["display"]) && cleanData($_GET["display"]) == "private") $display = "private";

	
} else $display = "public";

// update editor view
if ($isEditor) {
	if (!empty($_GET["view"]) && cleanData($_GET["view"]) == "edit") $view = "edit";
	if (!empty($_GET["view"]) && cleanData($_GET["view"]) == "approval") $view = "approval";
} // if 

// show grids
displayThumbnails($sort, $search, $display, $isEditor, $view);

// display footer
include "footer.inc";

//downloadAll();

?>