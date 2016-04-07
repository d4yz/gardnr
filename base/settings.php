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

if ((isset($_REQUEST['mod'])) && (isset($_REQUEST['modnum'])) && (is_numeric($_REQUEST['modnum']))) {	//Module Name Update: Check if mod and modnum is present and if modnum is digit
	//Verify Module Name is Okay to insert into database
	$new_mod_name = mysqli_real_escape_string($db_object,$_REQUEST['mod']);
	
	//Check if modnum is not 0 or >16
	
	if(($_REQUEST['modnum'] == 0) || ($_REQUEST['modnum'] > 16)){
		echo '<div class="container"><div class="alert alert-danger" id="Success">
		 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Ohh No!</strong> There was an error updating the module name!.
		</div></div>';	//Display Alert ID
		
	} else {	//Looks Okay. Update Module Name
	
		$qry = "UPDATE modules SET nickname = '".$new_mod_name."' WHERE id='".$_REQUEST['modnum']."'";
		$update_modname= mysqli_query($db_object,$qry);
		
		echo '<div class="container"><div class="alert alert-success" id="Success">
		 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Yippee!</strong> You have updated your modules name!.
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
	
	<hr>
	
	<h3>Module Nicknames</h3>
	
	<div class="container">
		
		<?php
			for($x=1;$x<=16;$x++){ 	//Display 16 Module Nicknames?>
				<form class="form-inline" role="form">
					<div class="form-group">
						<label for="mod<?php echo $x; ?>">Module <?php echo $x; ?>:</label>
						<input type="text" name="mod" class="form-control" id="mod<?php echo $x; ?>" value="<?php echo grab_modulenickname($x); //Grab Nickname from Database?>">
						<input type="text" name="modnum" class="hidden" value="<?php echo $x; ?>">
						<button type="submit" class="btn btn-default">Update</button>
					</div>
				</form>
				
		<?php	
			}	//End For Loop
		?>
		
	</div>
	
	<hr>
	
	<h3>Smooth Data</h3>
	
	Enable Smoothing of Data
	

	
	
	

	
	
	
    </div>
    <!-- /.container main -->


<?php include("footer.php") ?>