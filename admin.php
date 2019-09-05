<?php

ob_start();
session_start();

$_SESSION["isAdmin"] = true;

include "index.php";

?>