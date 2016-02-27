<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

ini_set('allow_url_fopen', 'on');
ini_set('allow_url_include', 'on');

 
define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!


$db_object = mysqli_connect("localhost", "root", "gardnr", "gardnr"); 

if (!$db_object) {
    die('Connect Error: ' . mysqli_connect_error());
}

include('functions.php');

?>
