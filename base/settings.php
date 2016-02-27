<?php 
include("header.php");

//Check for Updates
if (isset($_REQUEST['temp'])) {	//Temp Update
	if(is_numeric($_REQUEST['temp'])){	//Check if Numeric
		echo '<div class="container"><div class="alert alert-success" id="Success">
		 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Yippee!</strong> You have updated your Temperature Settings!.
		</div></div>';	//Display Alert ID
		
		//All good, lets add to database
		$qry = "UPDATE settings SET temperature = '".$_REQUEST['temp']."'";
		$update_temp= mysqli_query($db_object,$qry);
		
		
	} else { 	//Not numeric
		echo '<div class="container"><div class="alert alert-danger" id="Success">
		 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Ohh No!</strong> There was an error updating the temperature setting!.
		</div></div>';	//Display Alert ID
	}
	
	
	
}






//Read Settings from Database
$qry = "SELECT * FROM settings";
$settings_data = mysqli_query($db_object,$qry);

$settings_data = mysqli_fetch_array($settings_data, MYSQL_NUM);
$temp_setting=$settings_data[0];	//Temp Setting



?>





    <!-- Page Content -->
    <div class="container">
	<h2>Gardnr Settings</h2>
	
	<h3>Display Temperature</h3>
	
	Current Display: <?php if($temp_setting==1) echo 'Celsius'; if($temp_setting==2) echo 'Fahrenheit'; //Display Current Selection ?>
	
	<div class="container">
		<form class="form-inline" role="form">
			<label class="radio-inline active">
				<input type="radio" name="temp" value="1" <?php if($temp_setting==1) echo 'checked'; //Select Current Option ?> >Celsius
			</label>
			<label class="radio-inline">
				<input type="radio" name="temp" value ="2" <?php if($temp_setting==2) echo 'checked'; //Select Current Option ?> >Fahrenheit
			</label>
			
			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
	
	
	
	
	
	
	
	
    </div>
    <!-- /.container -->


<?php include("footer.php") ?>