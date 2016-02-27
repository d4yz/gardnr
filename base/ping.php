<?php
// $_SERVER['REMOTE_ADDR']; 
require 'db_connect.php';

//Check if ID is entered
if (!isset($_REQUEST['id'])) {
	echo '1';	//NO ID Set
	addlog("Error: No Module ID was set. IP Address: ".$_SERVER['REMOTE_ADDR'], 1);
	exit(1);
}

//Check if ID is numeric
if(!is_numeric($_REQUEST['id'])){
	echo '2';	//ID not numeric
	addlog("Error: Module ID was not Numeric. IP Address: ".$_SERVER['REMOTE_ADDR'], 1);
	exit(1);
}

if (!isset($_REQUEST['v'])) {
	echo '3';	//NO Version Set
	addlog("Error: No Version was set. IP Address: ".$_SERVER['REMOTE_ADDR'], 1);
	exit(1);
}

$qry = "UPDATE modules SET version = '".$_REQUEST['v']."', lastping=now(), ipaddress = '".$_SERVER['REMOTE_ADDR']."' WHERE id = '".$_REQUEST['id']."'";
$update_modules = mysqli_query($db_object,$qry);

echo '0'; //all good
addlog("Ping from Module ID: ".$_REQUEST['id'].". Version: ".$_REQUEST['v'].". IP Address: ".$_SERVER['REMOTE_ADDR'], 1);



?>

