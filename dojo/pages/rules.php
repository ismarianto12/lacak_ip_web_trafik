<?php
if ($_SERVER['SCRIPT_FILENAME'] == str_replace('\\', '/', __FILE__) ) { 
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\r\n<html><head>\r\n<title>404 Not Found</title>\r\n</head><body>\r\n<h1>Not Found</h1>\r\n<p>The requested URL " . $_SERVER['SCRIPT_NAME'] . " was not found on this server.</p>\r\n</body></html>");
}
	
?>
<div id="main">
	<div class="header">
		<h1>Rules Management</h1>
		<h2>Somebody gonna hate this!</h2>
	</div>
	
	<div class="content">	
		
		<h2 class="content-subhead">Rules List</h2>
		
		<table id="log-table" class="log-table">
			<thead>
				<tr>
					<th>Id</th>
					<th>Rule Name</th>
					<th>Rule Vector</th>
					<th>Risk</th>
					<th>Enabled</th>
				</tr>
			</thead>
			<tbody>
			<?php							
				$array_iterator = 0;
				foreach($barikode_rules_list as $r) {
					
					$val0=$val1=$val2=$val3='';
					if ($r[4]=="1") $val1="selected";
					if ($r[4]=="2") $val2="selected";
					if ($r[4]=="3") $val3="selected";
					
					$risk_options = '
						<select class="risk_options" data-array="'.$array_iterator.'">
							<option value="1" '.$val1.'>Low</option>
							<option value="2" '.$val2.'>Medium</option>
							<option value="3" '.$val3.'>High</option>
						</select>';
					
					if ($r[5]=="0") $val0="selected";
					if ($r[5]=="1") $val1="selected";
					
					$enabled_options = '
						<select class="enabled_options" data-array="'.$array_iterator.'">
							<option value="1" '.$val1.'>Yes</option>
							<option value="0" '.$val0.'>No</option>							
						</select>';
					echo '
					<tr>
						<td data-column="Id">'.$r[0].'</td>
						<td data-column="Rule Name">'.$r[1].'</td>
						<td data-column="Rule Vector">'.wordwrap($r[2]).'</td>
						<td data-column="Risk">'.$risk_options.'</td>
						<td data-column="Enabled">'.$enabled_options.'</td>
					</tr>
					';				
					$array_iterator++;
				}				
			?>
			</tbody>
		</table>
		<script>										
			$(document).ready(function() {
				$("#log-table").DataTable();
				
				$('#log-table tbody').on( 'change', '.enabled_options', function () {
					var that = this;										
					$.post("index.php?action=update-enabled",
						{ 
							"erow" : $(this).attr("data-array"), 
							"evalue" : $(this).val()
						}
						,function (data){
							if(data=="1337"){
								alert("Updated");
							} else {
								alert(data);
							}
					});						
					
					return false;
				});
				
				$('#log-table tbody').on( 'change', '.risk_options', function () {
					var that = this;										
					
					$.post("index.php?action=update-rule",
						{ 
							"row" : $(this).attr("data-array"), 
							"value" : $(this).val()
						}
						,function (data){
							if(data=="1337"){
								alert("Updated");
							} else {
								alert(data);
							}
					});						
					
					return false;
				});
			} );
		</script>
	</div>
</div>