<?php
if ($_SERVER['SCRIPT_FILENAME'] == str_replace('\\', '/', __FILE__) ) { 
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\r\n<html><head>\r\n<title>404 Not Found</title>\r\n</head><body>\r\n<h1>Not Found</h1>\r\n<p>The requested URL " . $_SERVER['SCRIPT_NAME'] . " was not found on this server.</p>\r\n</body></html>");
}
	if(isset($_POST['ip'])){
		$valid = filter_var($_POST['ip'], FILTER_VALIDATE_IP);
		if (!$valid) {
			$error = "Please fill it with valid IP";
		} else {
			$return = checkExistIP($_POST['ip']);
			if ($return[0]){
				$error = "Error : IP Exist.";
			} else {
				$write = time()."@@@".$_POST['ip']."@@@0@@@1".PHP_EOL;	
				@file_put_contents("..".BKSEPARATOR."banned.log",$write, FILE_APPEND | LOCK_EX);	
			}
		}
	}
	
	if(isset($_POST['ipwhite'])){
		$valid = filter_var($_POST['ipwhite'], FILTER_VALIDATE_IP);
		if (!$valid) {
			$errorwhite = "Please fill it with valid IP";
		} else {
			if (in_array($_POST['ipwhite'],$barikode_whitelist_ip)){
				$errorwhite = "Error : IP Exist.";
			} else {
				$write = '<?php $barikode_whitelist_ip = array(';
				if ($barikode_whitelist_ip){
					foreach ($barikode_whitelist_ip as $bwi):
						$write .= '"'.$bwi.'",';
					endforeach;					
				}
				$write .= '"'.$valid.'"';
				$write .= '); ?>';
				@file_put_contents("..".BKSEPARATOR."whitelist.ip.php",$write, LOCK_EX);
				header("location: index.php?do=ip");
			}			
		}
	}
?>
<div id="main">
	<div class="header">
		<h1>IP Management</h1>
		<h2>The last IP Bender here..</h2>
	</div>	
	
	<div class="content">
		
		<h2 class="content-subhead">Whitelist IP</h2>
		
		<form class="pure-form" action="" method="post">		
			<fieldset>				
				<?php
				if (isset($errorwhite)){
				?>
				<div class="msg-error"><?php echo $errorwhite;?></div>
				<?php } ?>
				<label for="ipwhite">Add whitelist IP</label>
				<input type="text" name="ipwhite" id="ipwhite" placeholder="ex : 1.3.3.7">
				
				<button type="submit" class="pure-button pure-button-primary">Submit</button>
			</fieldset>
		</form>
		<table id="log-white-table">
			<thead>
				<tr>
					<th>Whitelist IP</th>					
					<th>Remove</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if ($barikode_whitelist_ip)
				foreach ($barikode_whitelist_ip as $bwi) {					
					echo '
					<tr>
						<td data-column="IPWhitelist">'.$bwi.'</td>
						<td data-column="Remove"><button type="submit" class="pure-button button-error delete-button" data-white-ip="'.$bwi.'">Remove</button></td>
					</tr>
					';					
				}				
			?>
			</tbody>
		</table>
		
		<h2 class="content-subhead">Blocked IP</h2>
		
		<form class="pure-form" action="" method="post">		
			<fieldset>				
				<?php
				if (isset($error)){
				?>
				<div class="msg-error"><?php echo $error;?></div>
				<?php } ?>
				<label for="ip">Add blocked IP</label>
				<input type="text" name="ip" id="ip" placeholder="ex : 1.3.3.7">
				
				<button type="submit" class="pure-button pure-button-primary">Submit</button>
			</fieldset>
		</form>				
		
		<table id="log-table" class="log-table">
			<thead>
				<tr>
					<th>Timestamp</th>
					<th>Blocked IP</th>					
					<th>Rule ID</th>
					<th>Status</th>
					<th>Remove</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$file= "..".BKSEPARATOR."banned.log";
				$source_file = fopen( $file, "r" ) or die("Couldn't open $file");
				while (!feof($source_file)) {
					$buffer = fgets($source_file); 
					if($buffer != null){
						$data = explode("@@@",$buffer);
						if($data[3]==0) {
							$status = "Temporary";
						} else {
							$status = "Permanent";
						}
						echo '
						<tr';
						//if($i%2==0) echo ' class="pure-table-odd"';
						echo '
						>
							<td data-column="Timestamp">'.date('d-m-Y H:i:s',$data[0]).'</td>
							<td data-column="IP">'.$data[1].'</td>
							<td data-column="Rule ID">'.$data[2].'</td>
							<td data-column="Status">'.$status.'</td>
							<td data-column="Remove"><button type="submit" class="pure-button button-error delete-button" data-ip="'.$data[1].'">Remove</button></td>
						</tr>
						';
					}
				}
				fclose($source_file);
			?>
			</tbody>
		</table>
		<script>										
			$(document).ready(function() {
				$("#log-table,#log-white-table").DataTable({ 
					"order": [[ 0, "desc" ]],
					dom: "Bfrtip",
					buttons: [
						"copy", "csv", "excel", "pdf", "print"
					]
				});
				
				var table = $('#log-table').DataTable();
				$('#log-table tbody').on( 'click', '.delete-button', function () {
					var that = this;
					if (confirm("Are you sure want to remove IP "+$(this).attr("data-ip")+" from list?")) {
						$.post("index.php?action=delete-ip",
							{ "ipdelete" : $(this).attr("data-ip") }
						,function (data){
							if(data=="1337"){
								table
									.row( $(that).parents('tr') )
									.remove()
									.draw();							
							} else {
								alert(data);
							}
						});						
					}
					return false;
				});
				
				var tablewhite = $('#log-white-table').DataTable();
				$('#log-white-table tbody').on( 'click', '.delete-button', function () {
					var that = this;
					if (confirm("Are you sure want to remove IP "+$(this).attr("data-white-ip")+" from whitelist?")) {
						$.post("index.php?action=delete-white-ip",
							{ "ipdelete" : $(this).attr("data-white-ip") }
						,function (data){
							if(data=="1337"){
								tablewhite
									.row( $(that).parents('tr') )
									.remove()
									.draw();							
							} else {
								alert(data);
							}
						});						
					}
					return false;
				});
				
			} );
		</script>
	</div>
</div>