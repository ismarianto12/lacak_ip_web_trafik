<?php
if ($_SERVER['SCRIPT_FILENAME'] == str_replace('\\', '/', __FILE__) ) { 
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\r\n<html><head>\r\n<title>404 Not Found</title>\r\n</head><body>\r\n<h1>Not Found</h1>\r\n<p>The requested URL " . $_SERVER['SCRIPT_NAME'] . " was not found on this server.</p>\r\n</body></html>");
}
$barikode_options['livelog'] = barikode_getIP();
$barikode_options['livelog_time'] = time();
$write = "<?php".PHP_EOL."\$en_barikode_options=<<<'EN'".PHP_EOL.serialize($barikode_options).PHP_EOL."EN;".PHP_EOL;
@file_put_contents("..".BKSEPARATOR."options.barikode.php",$write, LOCK_EX);	
?>
<style>
#data {    
    height: 400px;
    overflow: auto;
	color:white;
	background:black;
	padding:3px;
}
</style>

<script type="text/javascript" src="./assets/js/jtail.js"></script>
<script type="text/javascript">
	setInterval(function(){
		$.post("index.php?action=live",{ "ajax":1 });
	}, 5000);
</script>
<div id="main">
	<div class="header">
		<h1>Live Log</h1>
		<h2>Hey, I can see you!</h2>
	</div>
	
	<div class="content">	
		<div id="header" style="margin-top:20px">
            <button id="pause" href='#'>Pause</button>.
        </div>
		<pre id="data">Loading...</pre>
	</div>
</div>
