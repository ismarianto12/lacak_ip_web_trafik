<?php
if ($_SERVER['SCRIPT_FILENAME'] == str_replace('\\', '/', __FILE__) ) { 
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\r\n<html><head>\r\n<title>404 Not Found</title>\r\n</head><body>\r\n<h1>Not Found</h1>\r\n<p>The requested URL " . $_SERVER['SCRIPT_NAME'] . " was not found on this server.</p>\r\n</body></html>");
}
?>
<div id="main">
	<div class="header">
		<h1>Dashboard</h1>
		<h2>Great, everything is under control!</h2>
	</div>	
	
	<div class="content">
		
		<form class="pure-form" action="" method="post">
			<fieldset>
				<h2 class="content-subhead">View Logs</h2>
				<label for="from">From</label>
				<input type="date" name="from" id="from" value="<?php if(!isset($_POST['from'])) { echo date("m/d/Y",time()); } else { echo $_POST['from'];} ;?>">
				
				<label for="to">To</label>
				<input type="date" name="to" id="to" value="<?php if (!isset($_POST['to'])) { echo date("m/d/Y",time()); } else { echo $_POST['to'];} ?>">
				
				<button type="submit" class="pure-button pure-button-primary">Submit</button>
			</fieldset>
		</form>
		
		<h2 class="content-subhead">Log Statistic</h2>
		<div class="pure-g">
			<div class="pure-u-1-4">
				<div class="statbox border-green">
					Low Risk <br> <span class="count" id="clow">0</span>
				</div>
			</div>
			<div class="pure-u-1-4">
				<div class="statbox border-orange">
					Medium Risk <br> <span class="count" id="cmedium">0</span>
				</div>
			</div>
			<div class="pure-u-1-4">
				<div class="statbox border-red">
					High Risk <br> <span class="count" id="chigh">0</span>
				</div>
			</div>
			<div class="pure-u-1-4">
				<div class="statbox border-blue" style="margin-right:0px">
					Total <br> <span class="count" id="ctotal">0</span>
				</div>
			</div>			
		</div>
		
		<h2 class="content-subhead">Logs Detail</h2>
		<table id="log-table" class="log-table">
			<thead>
				<tr>
					<th>Timestamp</th>
					<th>IP</th>
					<th>Attack Vector</th>
					<th>URL</th>
					<th>Parameter</th>
					<th>Attack Query</th>
					<th>Rule ID</th>
					<th>Severity</th>
				</tr>
			</thead>
			<tbody>
			<?php			
				$logs_folder= "..".BKSEPARATOR."logs";
				
				if(is_dir($logs_folder)){
					$di = new RecursiveDirectoryIterator($logs_folder,RecursiveDirectoryIterator::SKIP_DOTS);
					$it = new RecursiveIteratorIterator($di);
				} else {
					$it = false;
				}
				
				$chigh   = 0;
				$cmedium = 0;
				$clow    = 0;
				$ctotal    = 0;
				
				$from = "";
				$to = "";
				if(!isset($_POST['from'])) {
					$from = mktime(0,0,0, date("m",time()), date("d",time()), date("Y",time()));
				} else {
					$from = mktime(0,0,0, date("m",strtotime($_POST['from'])), date("d",strtotime($_POST['from'])), date("Y",strtotime($_POST['from'])));
				}
				if(!isset($_POST['to'])) {
					$to = mktime(0,0,0, date("m",time()), date("d",time()), date("Y",time()));
				} else {
					$to = mktime(0,0,0, date("m",strtotime($_POST['to'])), date("d",strtotime($_POST['to'])), date("Y",strtotime($_POST['to'])));
				}				
				
				if($it) foreach($it as $file) {
					$date_file = str_replace(".log","",$file);
					$date_file = explode(BKSEPARATOR,$date_file);
					$df = $date_file[3].'/'.$date_file[4].'/'.$date_file[2];										
					
					$epoch_df = mktime( 0, 0, 0, $date_file[3], $date_file[4], $date_file[2]);
										
					if (($epoch_df < $from) or ($epoch_df > $to)) { continue; }
					
					if (pathinfo($file, PATHINFO_EXTENSION) == "log") {
						$source_file = fopen( $file, "r" ) or die("Couldn't open $file");
						while (!feof($source_file)) {
							$buffer = fgets($source_file); 
							if($buffer != null){
								$data = explode("@@@",$buffer);
								switch ($data[4]){
									case 1 :
										$s = "border-green";
										$v = "Low";
										$clow ++;
										break;
									case 2 :
										$s = "border-orange";
										$v = "Medium";
										$cmedium++;
										break;
									case 3 :
										$s = "border-red";
										$v = "High";
										$chigh++;
										break;
									default :
										break;
								}
								echo '
								<tr';
								//if($i%2==0) echo ' class="pure-table-odd"';
								echo '
								>
									<td data-column="Timestamp">'.date('d-m-Y H:i:s',$data[0]).'</td>
									<td data-column="IP">'.$data[1].'</td>
									<td data-column="Attack Vector">'.$data[3].'</td>
									<td data-column="URL">'.htmlspecialchars($data[8], ENT_QUOTES).'</td>										
									<td data-column="Parameter">['.$data[2].'] '.htmlspecialchars($data[6], ENT_QUOTES).'</td>
									<td data-column="Atack Query" class="fixwidth">'.wordwrap(htmlspecialchars(trunc($data[7]), ENT_QUOTES), 20 , ' ' , true).'</td>
									<td data-column="Rule ID">'.$data[5].'</td>
									<td data-column="Severity" class="statbox-normal '.$s.'">'.$v.'</td>
								</tr>
								';
							}
						}
						fclose($source_file);
					}
				}
				echo '
				<script>										
					$(document).ready(function() {
						$("#log-table").DataTable({ 
							"order": [[ 0, "desc" ]],
							dom: "Bfrtip",
							buttons: [
								"copy", "csv", "excel", "pdf", "print"
							]
						});
						$("#clow").text("'.$clow.'");
						$("#cmedium").text("'.$cmedium.'");
						$("#chigh").text("'.$chigh.'");
						$("#ctotal").text("'.($clow+$cmedium+$chigh).'");
						$(".count").each(function () {
						  var $this = $(this);
						  jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
							duration: 5000,
							easing: "swing",
							step: function () {
							  $this.text(Math.ceil(this.Counter));
							}
						  });
						});
						
						 $( "input[type=date]" ).each( function() {
							$( this ).clone().attr( "type", "text" ).insertAfter( this ).datepicker().prev().remove();
						  } );
					} );
				</script>
				';
			?>							
			</tbody>
		</table>
	</div>
</div>

