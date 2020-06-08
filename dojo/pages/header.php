<?php
if ($_SERVER['SCRIPT_FILENAME'] == str_replace('\\', '/', __FILE__) ) { 
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\r\n<html><head>\r\n<title>404 Not Found</title>\r\n</head><body>\r\n<h1>Not Found</h1>\r\n<p>The requested URL " . $_SERVER['SCRIPT_NAME'] . " was not found on this server.</p>\r\n</body></html>");
}
function trunc($text){
	$textLength = strlen($text);
	$maxChars = 76;
	if($textLength > $maxChars){
		$text = substr_replace($text, '[RED]', $maxChars/2, $textLength-$maxChars);
	}
	return $text;
}
if ($_SESSION['barikode_update']==1){
	$notif = '<span style="border-radius:3px;background:#A29360;color:white;padding:3px;">new</span>';
} else {
	$notif = '';
}
?>
<!Doctype html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="assets/images/firewall.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Barikode dojo panel">

    <title>Barikode Dojo Panel</title>
	
	<link rel="stylesheet" href="assets/css/pure-min.css">

    <!--[if lte IE 8]>
        <link rel="stylesheet" href="assets/css/layouts/side-menu-old-ie.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="assets/css/datatables.css">
		<link rel="stylesheet" href="assets/css/layouts/side-menu.css">
		<link rel="stylesheet" href="assets/css/jquery-ui.css">
		<link rel="stylesheet" href="assets/css/jquery.dataTable.min.css">
		<link rel="stylesheet" href="assets/css/buttons.dataTable.min.css">
        
    <!--<![endif]-->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery-ui.min.js"></script>
		<script src="assets/js/jquery.dataTables.min.js"></script>
		 
		<script src="assets/js/dataTables.buttons.min.js"></script>
		<script src="assets/js/buttons.flash.min.js"></script>
		<script src="assets/js/jszip.min.js"></script>
		<script src="assets/js/pdfmake.min.js"></script>
		<script src="assets/js/vfs_fonts.js"></script>
		<script src="assets/js/buttons.html5.min.js"></script>
		<script src="assets/js/buttons.print.min.js"></script>
</head>
<body>

<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="#"><img src="assets/images/firewall.png" style="width:35px"> Barikode WAF</a>

            <ul class="pure-menu-list">
                <li class="pure-menu-item <?php if ((!isset($_GET['do'])) or ($_GET['do']=='dashboard')) echo "pure-menu-selected"; ?>"><a href="?do=dashboard" class="pure-menu-link">Home</a></li>
                <li class="pure-menu-item <?php if ((isset($_GET['do'])) and ($_GET['do']=='ip')) echo "pure-menu-selected"; ?>"><a href="?do=ip" class="pure-menu-link">IP Management</a></li>
				<li class="pure-menu-item <?php if ((isset($_GET['do'])) and ($_GET['do']=='rules')) echo "pure-menu-selected"; ?>"><a href="?do=rules" class="pure-menu-link">Rules Management</a></li>
				<li class="pure-menu-item <?php if ((isset($_GET['do'])) and ($_GET['do']=='var')) echo "pure-menu-selected"; ?>"><a href="?do=var" class="pure-menu-link">Parameter Management</a></li>
				<li class="pure-menu-item <?php if ((isset($_GET['do'])) and ($_GET['do']=='live')) echo "pure-menu-selected"; ?>"><a href="?do=live" class="pure-menu-link">Live Log</a></li>
				<li class="pure-menu-item <?php if ((isset($_GET['do'])) and ($_GET['do']=='setting')) echo "pure-menu-selected"; ?>"><a href="?do=setting" class="pure-menu-link">General Setting</a></li>				
				<li class="pure-menu-item <?php if ((isset($_GET['do'])) and ($_GET['do']=='update')) echo "pure-menu-selected"; ?>"><a href="?do=update" class="pure-menu-link">Check Updates <?php echo $notif;?></a></li>
				<li class="pure-menu-item <?php if ((isset($_GET['do'])) and ($_GET['do']=='logout')) echo "pure-menu-selected"; ?>"><a href="?do=logout" class="pure-menu-link">Logout</a></li>
            </ul>
        </div>
    </div>