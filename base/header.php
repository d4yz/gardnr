<?php 
	##Security Check## - Check to see if file is open without include
	if(preg_match('/header/',$_SERVER['PHP_SELF'])){
	header('Location:index.php');}
	
	require("db_connect.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Gardnr</title>

	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<script src="./js/bootstrap.min.js"></script>
  
	<style>
		body {
			padding-top: 70px;
			/* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
		}
	</style>
</head>
<body>

	<!-- Navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				    <span class="sr-only">Toggle navigation</span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Gardnr</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="about.php">About</a></li>
				<li><a href="viewdata.php">View Data</a></li>
				<li><a href="viewlog.php">View Log</a></li>
				<li><a href="settings.php">Settings</a></li>
				<li><a href="#contact">Help</a></li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
	</nav>