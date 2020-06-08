<!doctype html>
<html>
<head>
	<title>Barikode WAF Setup</title>
	<style>
	body{
		background:#171717;
		color:#808080;
		font-family: arial,sans-serif;
	}
	.ok{
		padding:2px;
		color:white;
		background:#169916;
	}
	.error{
		padding:2px;
		color:white;
		background:red;
	}
	#wrap{
		margin:20px auto;
		width:800px;
		padding:0px 10px 10px 10px;
		border:1px black solid;
		background:white;
	}
	.wrap{
		margin:20px auto;
		width:800px;
		padding:0px 10px 10px 10px;
		text-align:center;
	}
	a{
		color: #A29360; text-decoration: none;
	}
	ol li{
		margin:10px 0px;
	}
	h1{
		font-size: 2em;
		font-weight: 100;
		letter-spacing: -1px;
		text-align: center;
		text-transform: uppercase;
	}
	
	h1, h2, h3, h4, h5, h6 { border:1px solid #9B8747;padding:5px;color:white;background:#A29360;} 
	</style>
</head>

<body>

<div id="wrap">
	<h1 style="text-align:center">Barikode WAF Setup</h1>
	<?php
	if (isset($barikode_install)){
		echo "<p>Congratulations Barikode WAF successfully installed!, this is your credential login : </p>
		<table border=0>
			<tr>
				<td>Panel URL</td>
				<td>: <a href='dojo'>Dojo Panel</td>
			</tr>
			<tr>
				<td>Username </td>
				<td>: admin</td>
			</tr>
			<tr>
				<td>Password </td>
				<td>: welcome</td>
			</tr>			
		</table>
		<p>Note: please change your password immediately, and delete or rename install.php file</p>
		";
	} else {
		$_SESSION['bkerror'] = 0;
		function perm($f){
			if (is_writable($f)) {
				return '<span class="ok">Good!</span>';
			} else {
				@chmod($f, 0755);
				if (is_writable($f)) {
					return '<span class="ok">Great, we can make it writeable!</span>';
				} else {
					$_SESSION['bkerror'] = $_SESSION['bkerror'] + 1;
					return '<span class="error">'.$f.' unwritable, set 0755 to '.$f.'</span>';
				}
			}
		}
		?>
		<ol>
		<li>Check permission for logs folder : <?php echo perm(__DIR__ . '/logs/'); ?> </li>
		<li>Check permission for options.barikode.php : <?php echo perm(__DIR__ . '/options.barikode.php'); ?> </li>
		<li>Check permission for rules.barikode.php : <?php echo perm(__DIR__ . '/rules.barikode.php'); ?> </li>
		<li>Check permission for live.log : <?php echo perm(__DIR__ . '/live.log'); ?> </li>
		<li>Check permission for banned.log : <?php echo perm(__DIR__ . '/banned.log'); ?> </li>
		<li>Check permission for banned_history.log : <?php echo perm(__DIR__ . '/banned_history.log'); ?> </li>
		<li>Check permission for modfile.log : <?php echo perm(__DIR__ . '/modfile.log'); ?> </li>
		<li>Check permission for whitelist.ip.php : <?php echo perm(__DIR__ . '/whitelist.ip.php'); ?> </li>
		<li>Check permission for ignore.var.php : <?php echo perm(__DIR__ . '/ignore.var.php'); ?> </li>

		<?php 
		if ($_SESSION['bkerror'] > 0) { 
			echo "<p>Please check error above</p>";
		} else {	
			if (PHP_OS=="Linux"){
				$slash="/";
			} else {
				$slash="\\";
			}
			if ((php_sapi_name() == "cgi") or (php_sapi_name() =="cgi-fcgi")) {
				$file="php.ini";
				$pre = "auto_prepend_file = ";
			} else {
				$file=".htaccess";
				$pre = "php_value auto_prepend_file ";
			}
		?>
			<li> Detected using <b><?php echo php_sapi_name(); ?></b>. Copy and paste the following code into your <b><?php echo $_SERVER["DOCUMENT_ROOT"].$slash.$file; ?></b> file at the first line.</li>
			
			<textarea rows="3" cols="60" onclick="this.focus();this.select()" readonly="readonly" style="margin-bottom:20px;"><?php echo $pre . __DIR__ . $slash;?>barikode.php</textarea>
				
			<?php
			if ((php_sapi_name() == "cgi") or (php_sapi_name() =="cgi-fcgi")) {
			?>
				<h3>Alternative solution</h3>
				<p>Copy and paste the following code into your <b><?php echo $_SERVER["DOCUMENT_ROOT"].$slash.".user.ini"; ?></b> file at the first line.</p>
				
				<textarea rows="3" cols="60" onclick="this.focus();this.select()" readonly="readonly" style="margin-bottom:20px;"><?php echo $pre . __DIR__ . $slash;?>barikode.php</textarea>				
			<?php
			}
			if (isset($_GET['check'])){
				echo '<p style="color:red">Please review again your code, if same thing happened you can try following solution : </p>';
			?>
			
			<li>Copy and paste the following code into your <b><?php echo $_SERVER["DOCUMENT_ROOT"].$slash.".user.ini"; ?></b> file at the first line.</li>
			
				<textarea rows="3" cols="60" onclick="this.focus();this.select()" readonly="readonly" style="margin-bottom:20px;"><?php echo $pre . __DIR__ . $slash;?>barikode.php</textarea>
				
			<?php
			}
			echo '</ol><p style="text-align:center;"><a style="border:1px solid #9B8747;padding:5px;color:white;background:#A29360;" href="?check=1">Click here if you have installed the code above</a><p>';
		}
	}
	?>
</div>
<div class="wrap">
<a href="https://www.ethic.ninja/" style="color:white;text-align:center">Copyright Ethic Ninja <?php echo date("Y",time());?></a>
</div>
</body>
</html>