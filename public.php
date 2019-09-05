<?php

ob_start();
session_start();

$_SESSION["isAdmin"] = false;

include "index.php";

?>