<?php
if ($_SERVER['SCRIPT_FILENAME'] == str_replace('\\', '/', __FILE__) ) { 
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\r\n<html><head>\r\n<title>404 Not Found</title>\r\n</head><body>\r\n<h1>Not Found</h1>\r\n<p>The requested URL " . $_SERVER['SCRIPT_NAME'] . " was not found on this server.</p>\r\n</body></html>");
}
?>

<div id="main">
	<div class="header">
		<h1>Check for Updates</h1>
		<h2>Feed me..</h2>
	</div>
	
	<div class="content">
		<p style="font-family:courier">		
		<?php 
			barikode_check_update($barikode_options,$barikode_rules_list);
		?>
		</p>		
	</div>
</div>
