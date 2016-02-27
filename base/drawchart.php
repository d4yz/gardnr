<?php

	if($type==1){	//Set Temp Variables
		$type_shortcode='Temperature';
		$type_title = 'Module 1 Temperature';
		$type_divname = 'TempChart';
	}
	
	if($type==2){	//Set Light Variables
		$type_shortcode='Light';
		$type_title = 'Module 1 Light Exposure';
		$type_divname = 'LightChart';
	}
	
	if($type==3){	//Set Moisture Variables
		$type_shortcode='Moisture';
		$type_title = 'Module 1 Soil Moisture';
		$type_divname = 'MoistureChart';
	}
	
	if($type==4){	//Set Soil Temp Variables
		$type_shortcode='Soil Temperature';
		$type_title = 'Module 1 Soil Temperature';
		$type_divname = 'SoilTempChart';
	}
	
	if($type==5){	//Set Humidity Variables
		$type_shortcode='Humidity';
		$type_title = 'Module 1 Humidity';
		$type_divname = 'HumidityChart';
	}
	
	
	
	//Grab Data
	//$qry="SELECT * FROM moduledata WHERE moduleid=".$_REQUEST['id']." ORDER BY id ASC LIMIT 5500";
	$qry = "SELECT * FROM (SELECT * FROM moduledata  WHERE moduleid=".$_REQUEST['id']." ORDER BY id DESC LIMIT 5500) AS a ORDER BY ID";
	$datainfo = mysqli_query($db_object,$qry);
	
	$datacount = mysqli_num_rows($datainfo);
		
	if($datacount == 0){	//If no data exists tell them
		echo '<div class="text-center">Sorry, no data exists for this module.</div>';
	} else {	//If Data Exists draw table
?>


<script type="text/javascript"
	src="https://www.google.com/jsapi?autoload={
	'modules':[{
	'name':'visualization',
	'version':'1',
	'packages':['corechart']
	}]
	}">
</script>

<script type="text/javascript">
	google.setOnLoadCallback(drawChart);

	function drawChart() {
		var data = google.visualization.arrayToDataTable([
		['Time', '<?php echo $type_shortcode; ?>'],
	  
		<?php 
	  
		//$qry = "SELECT * FROM (SELECT * FROM moduledata ORDER BY id DESC LIMIT 5500) AS a ORDER BY ID";
		
			//$x=0;
			while($chartdata = mysqli_fetch_array($datainfo, MYSQL_NUM)){ 
			//$x++;
				$id_chartdata=$chartdata[0];
				$module_chartdata=$chartdata[1];
				$date_chartdata=$chartdata[2];
				$plotinfo_chartdata=$chartdata[$type+2];	//Add 2 to type to get column from database
				
				if($type==1){	//Temperature Data Manipulation
				//	$tempK = $plotinfo_chartdata* 0.003222656 * 100;    //Read temperature in Kelvins first
					
					//if($temp_setting==1){	//Convert to Celsius
					//	$plotinfo_chartdata = round($tempK - 273.15,2);    //Convert from Kelvin to Celsius and Round to 2 Decimals
					//}
					if($temp_setting==2){	//Convert to Fahrenheit
						$plotinfo_chartdata = round((($plotinfo_chartdata) * 9 / 5) + 32, 2);    //Convert from Kelvin to Fahrenheit and Round to 2 Decimals
						//$plotinfo_chartdata = round((($tempK) * 9 / 5) - 459.67, 2);    //Convert from Kelvin to Fahrenheit and Round to 2 Decimals
					}
				}
				
				if($type==4){ //Soil Temperature Manipulation
					$tempK = $plotinfo_chartdata* 0.003222656 * 100;    //Read temperature in Kelvins first
					
					if($temp_setting==1){	//Convert to Celsius
						$plotinfo_chartdata = round($tempK - 273.15,2);    //Convert from Kelvin to Celsius and Round to 2 Decimals
					}
					if($temp_setting==2){	//Convert to Fahrenheit
						$plotinfo_chartdata = round((($tempK) * 9 / 5) - 459.67, 2);    //Convert from Kelvin to Fahrenheit and Round to 2 Decimals
					}
				
				}
		
				//if($x==15){
					echo "['".$date_chartdata."', ".$plotinfo_chartdata."],";
					//$x=0;
					//}

			}
		?>
	  
		]);

		var options = {
			title: '<?php echo $type_title; ?> - Current <?php echo $type_shortcode; ?>: <?php echo $plotinfo_chartdata; ?>',
			curveType: 'function',
			legend: { position: 'bottom' }
		};

		var chart = new google.visualization.LineChart(document.getElementById('<?php echo $type_divname; ?>'));

		chart.draw(data, options);
	}
</script>


<div id="<?php echo $type_divname; ?>" style="width: 500; height: 450"></div>

<?php } //End bracket for drawing chart ?>