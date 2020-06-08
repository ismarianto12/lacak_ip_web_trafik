<?php
if ($_SERVER['SCRIPT_FILENAME'] == str_replace('\\', '/', __FILE__) ) { 
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\r\n<html><head>\r\n<title>404 Not Found</title>\r\n</head><body>\r\n<h1>Not Found</h1>\r\n<p>The requested URL " . $_SERVER['SCRIPT_NAME'] . " was not found on this server.</p>\r\n</body></html>");
}		
	if(isset($_POST['ignore_param'])){
		$valid = barikode_normalize($_POST['ignore_param']);
		if (in_array($valid,$barikode_ignore_var)){
			$errorwhite = "Error : Parameter exist.";
		} else {
			$write = '<?php $barikode_ignore_var = array(';
			if ($barikode_ignore_var){
				foreach ($barikode_ignore_var as $biv):
					$write .= '"'.$biv.'",';
				endforeach;					
			}
			$write .= '"'.$valid.'"';
			$write .= '); ?>';
			@file_put_contents("..".BKSEPARATOR."ignore.var.php",$write, LOCK_EX);
			header("location: index.php?do=var");
		}		
	}
?>
<div id="main">
	<div class="header">
		<h1>Ignored Parameter Management</h1>
		<h2>Parameter that dont need sanitation</h2>
	</div>	
	
	<div class="content">
		
		<h2 class="content-subhead">Ignore Parameter</h2>
		
		<form class="pure-form" action="" method="post">		
			<fieldset>				
				<?php
				if (isset($error)){
				?>
				<div class="msg-error"><?php echo $error;?></div>
				<?php } ?>
				<label for="ignore_param">Add ignore parameter</label>
				<input type="text" name="ignore_param" id="ignore_param" placeholder="ex : password">
				
				<button type="submit" class="pure-button pure-button-primary">Submit</button>
			</fieldset>
		</form>
		<table id="log-table">
			<thead>
				<tr>
					<th>Ignore parameter</th>					
					<th>Remove</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if ($barikode_ignore_var)
				foreach ($barikode_ignore_var as $biv) {					
					echo '
					<tr>
						<td data-column="igparam">'.$biv.'</td>
						<td data-column="Remove"><button type="submit" class="pure-button button-error delete-button" data-ignore-param="'.$biv.'">Remove</button></td>
					</tr>
					';
				}
			?>
			</tbody>
		</table>
		
		<script>										
			$(document).ready(function() {
				$("#log-table").DataTable({ 
					"order": [[ 0, "desc" ]],
					dom: "Bfrtip",
					buttons: [
						"copy", "csv", "excel", "pdf", "print"
					]
				});
				
				var table = $('#log-table').DataTable();
				$('#log-table tbody').on( 'click', '.delete-button', function () {
					var that = this;
					if (confirm("Are you sure want to remove parameter "+$(this).attr("data-ignore-param")+" from list?")) {
						$.post("index.php?action=delete-ignore-param",
							{ "paramdelete" : $(this).attr("data-ignore-param") }
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
				
			} );
		</script>
	</div>
</div>