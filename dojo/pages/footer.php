<?php
if ($_SERVER['SCRIPT_FILENAME'] == str_replace('\\', '/', __FILE__) ) { 
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\r\n<html><head>\r\n<title>404 Not Found</title>\r\n</head><body>\r\n<h1>Not Found</h1>\r\n<p>The requested URL " . $_SERVER['SCRIPT_NAME'] . " was not found on this server.</p>\r\n</body></html>");
}
?>
	<div style="text-align:center;padding:10px 0px;background:#191818;"><a style="text-decoration:none;color:#A29360;" href="https://www.ethic.ninja">Copyright Ethic Ninja <?php echo date("Y", time());?></a></div>
</div>

<script src="assets/js/ui.js"></script>
</body>
</html>