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

//Go to a Url and Return the Website as a Variable
function get_url_contents($url){
        $crl = curl_init();
        $timeout = 5;
	$header = array("Cache-Control: no-cache");

	curl_setopt($crl, CURLOPT_HTTPHEADER, $header);
        curl_setopt ($crl, CURLOPT_URL,$url);
        curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($crl, CURLOPT_FRESH_CONNECT, TRUE);
        $ret = curl_exec($crl);
        curl_close($crl);
        return $ret;
}

//Returns the Current Base Version
function grab_current_base_version(){
	return file_get_contents( "version" );
}

//Check if there is a New Base Version and Display Message
function check_new_base_version(){
	//Head to Server to Grab current released base version
	$new_version=get_url_contents('http://xuzzer.ipage.com/gardnr/version');

	//Check if grabbed version is higher then installed version
	if($new_version > grab_current_base_version()){
		//Display a Message
		echo '<div class="container"><div class="alert alert-success" id="Success">
		 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Yippee!</strong> There is a new Gardnr Base version available (Version '.$new_version.') Head over to www.gardnr.io to update.
		</div></div>';	//Display Alert ID
	}

}















?>