<?php include("header.php"); ?>

	<!-- Page Content -->
	<div class="container">
		<h4>Gardnr Status</h4>
		
		<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>Hostname</th>
					<th>Base IP</th>
					<th>Current Time</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php system("hostname"); ?></td>
					<td><?php system("hostname -I"); ?></td>
					<td><?php system('date "+%b %d - %H:%M"'); ?></td>
				</tr>
			     
			</tbody>
		</table>
		</div><!-- End Table Div -->
	
	</div> <!-- /.container -->
	
	
<!-- Page Content -->
<div class="container">
	<h4>Module Data</h4>
	
	<div class="table-responsive">
	<table class="table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nickname</th>
			<th>Status</th>
			<th>Data Points</th>
			<th>Version</th>
			<th>IP Address</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$qry = "SELECT * FROM modules ORDER BY id ASC";
		$moduleinfo = mysqli_query($db_object,$qry);

		while($moduledata = mysqli_fetch_array($moduleinfo, MYSQL_NUM)){
			$module_id=$moduledata[0];
			$module_nickname=$moduledata[1];
			$module_lastping=$moduledata[2];
			$module_version=$moduledata[3];
			$module_ipaddress=$moduledata[4];
			
			//Calculate Last Ping in Seconds
			$lastping_seconds=strtotime($module_lastping);
			$lastping_seconds=time() - $lastping_seconds;
			
			if($module_version == '0') $module_version = 'N/A';
			if($module_ipaddress == '0') $module_ipaddress = 'N/A';
				
			echo '<tr>';
				echo'<td>'.$module_id.'</td>';
				echo'<td>'.$module_nickname.'</td>';
				
				//Display  Connected or Disconnect if Ping in last 15 minutes
				if($lastping_seconds < 900)	//900 is 15 minutes
					echo'<td class="success">Connected</td>';
				else
					echo'<td class="danger">Disconnected</td>';
				
				echo'<td>'.grab_datapointcnt($module_id).'</td>';
				echo'<td>'.$module_version.'</td>';
				echo'<td>'.$module_ipaddress.'</td>';
			echo '</tr>';
		}
	?>
	</tbody>
	</table>
	</div>
</div><!-- /.container -->
    








<?php /*

	      <tr>
		<td>1</td>
		<td>Doe</td>
		<td class="success">Connected</td>
		<td>34,331</td>
		<td><?php system('date "+%b %d - %H:%M"'); ?></td>
		<td>0.1</td>
		<td>192.168.1.1</td>
	      </tr>












    <input id="txtBox" type="textbox" value="0" style="display:none;" /><span id="txtBoxValue">0</span>
<script>
    $(function() {
        $('#txtBoxValue').on('click', function() {
            $(this).hide();
            $('#txtBox').show();
        });
    
        $('#txtBox').on('blur', function() {
            var that = $(this);
            $('#txtBoxValue').text(that.val()).show();
            that.hide();
        });
    });
</script>

*/ ?>

<?php include("footer.php"); ?>