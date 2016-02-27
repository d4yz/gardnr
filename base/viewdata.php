<?php

include ("header.php");		//html for top of site

//Read Settings
$qry = "SELECT * FROM settings";
$settings_data = mysqli_query($db_object,$qry);

$settings_data = mysqli_fetch_array($settings_data, MYSQL_NUM);
	$temp_setting=$settings_data[0];	//Temp Setting


if (!isset($_REQUEST['id'])) { 
?>

<div class="container">
	<h4>Module Data</h4>
	
	<div class="table-responsive">
	<table class="table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nickname</th>
			<th>Data Points</th>
			<th>View Data</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$qry = "SELECT * FROM modules ORDER BY id ASC";
		$moduleinfo = mysqli_query($db_object,$qry);

		while($moduledata = mysqli_fetch_array($moduleinfo, MYSQL_NUM)){
			$module_id=$moduledata[0];
			$module_nickname=$moduledata[1];
				
			echo '<tr>';
				echo'<td>'.$module_id.'</td>';
				echo'<td>'.$module_nickname.'</td>';
				echo'<td>'.grab_datapointcnt($module_id).'</td>';
				echo'<td><a href="viewdata.php?id='.$module_id.'">View Data</a></td>';
			echo '</tr>';
		}
	?>
	</tbody>
	</table>
	</div>
</div><!-- /.container -->


<?php
} else {	//ID is Set
	if(!is_numeric($_REQUEST['id'])){	//Check if ID is numeric
		echo '<div class="container">Error: ID value is invalid. </div>';	//Display Error
		include ("footer.php");	//html of bottom of site
		exit(1);
	} else {	//Display Module Data
		?>
		
		<div class="container">
		<h4>View Module Data</h4>
		
			<?php 
				//Draw Temp Chart
				$type=1; 	//Pass type variable to drawchart.php
				include ("drawchart.php");
				
				//Draw Light Chart
				$type=2; 	//Pass type variable to drawchart.php
				include ("drawchart.php");
				
				//Draw Moisture Chart
				$type=3; 	//Pass type variable to drawchart.php
				include ("drawchart.php");
				
				//Draw Soil Temp Chart
				$type=4; 	//Pass type variable to drawchart.php
				include ("drawchart.php");
				
				//Draw Humidity Chart
				$type=5; 	//Pass type variable to drawchart.php
				include ("drawchart.php");
			?>
	

		</div>
	

		<?php
	}
}	//End If for Initial ID check

?>



















<?php 
include ("footer.php");	//html of bottom of site

?>