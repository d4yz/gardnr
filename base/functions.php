<?php
##Security Check## - Check to see if file is open without include
if(preg_match('/functions/',$_SERVER['PHP_SELF'])){
header('Location:index.php');}

//Thos function is used to get the data point count from the database for a particular module ID
function grab_datapointcnt($module_id) {	
	global $db_object; //Declare global variable
	
	$qry = "SELECT * FROM moduledata WHERE moduleid = '".$module_id."'";
	$count = mysqli_query($db_object,$qry);

	return number_format(mysqli_num_rows($count));
}

//This function adds data to the log text. $log 1 is for pings. If $log is 2 its data log
function addlog($text,$log){
	if($log=="1") $logfile="pinglog.txt";	//Select Ping Log
	if($log=="2") $logfile="datalog.txt";	//Select Data Log
	
	//Add Line to Log
	$filename = fopen($logfile, "a");
	$txt = date("Y-m-d H:i:s")." - ".$text."\n";
	fwrite($filename, $txt);
	fclose($filename);
}

//This funtion returns the nickname from the Module ID
function grab_modulenickname($module_id) {	
	global $db_object; //Declare global variable
	
	$qry = "SELECT * FROM modules WHERE id = '".$module_id."' LIMIT 1";
	$qry_data = mysqli_query($db_object,$qry);
	
	$data = mysqli_fetch_array($qry_data, MYSQL_NUM);
	
	return $data[1];	 //Return Module Name
}







?>