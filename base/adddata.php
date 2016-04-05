<?php

require 'db_connect.php';

	
//Check if ID is entered
if (!isset($_REQUEST['id'])) {
	echo '1';	//NO ID Set
	addlog("Error: No Module ID was set. IP Address: ".$_SERVER['REMOTE_ADDR'], 2);
	exit(1);
}

//Check if ID is numeric
if(!is_numeric($_REQUEST['id'])){
	echo '2';	//ID not numeric
	addlog("Error: Module ID was not Numeric. IP Address: ".$_SERVER['REMOTE_ADDR'], 2);
	exit(1);
}


	if (!isset($_REQUEST['temp'])) { $temp=0; } else {$temp = $_REQUEST['temp']; }
	if (!isset($_REQUEST['light'])) { 	$light=0; 	} else {$light = $_REQUEST['light']; }
	if (!isset($_REQUEST['moisture'])) { 	$moisture=0; } else {$moisture = $_REQUEST['moisture']; }
	if (!isset($_REQUEST['stemp'])) { 	$stemp=0; } else {$stemp = $_REQUEST['stemp']; }
	if (!isset($_REQUEST['hum'])) { 	$humidity=0; } else {$humidity = $_REQUEST['hum']; }
	
	
	
	//if (!is_float($temp)) { if (!is_numeric($temp)) { echo '4'; exit(1); }}
	//if (!is_float($light)) { if (!is_numeric($light)) { 	echo '5'; exit(1); }}
	//if (!is_float($moisture)) { if (!is_numeric($moisture)) { 	echo '6';exit(1); }}
	//if (!is_float($stemp)) { if (!is_numeric($stemp)) { 	echo '7'; 	exit(1); }}
	

	
	$insert = "INSERT INTO moduledata (
	moduleid, 
	temp, 
	light,
	moisture,
	soiltemp,
	humidity
	) 
            VALUES (
            '".$_REQUEST['id']."', 
            '".$temp."', 
	    '".$light."', 
            '".$moisture."', 
	    '".$stemp."',
	     '".$humidity."'
	    )";

	$adddata= mysqli_query($db_object,$insert);
	
	echo '0';
	addlog("Data from Module ID: ".$_REQUEST['id'].". T:".$temp." L:".$light." M:".$moisture." S:".$stemp." H:".$humidity." IP Address: ".$_SERVER['REMOTE_ADDR'], 2);


?>

