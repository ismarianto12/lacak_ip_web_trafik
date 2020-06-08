<?php
session_start();

if (!isset($barikode_rules_list)) die ("Error occured or your license is expired please contact info@ethic.ninja");

function csrf_startup() {
    csrf_conf('rewrite-js', 'anticsrf/csrf-magic.js');
    if (isset($_POST['ajax'])) csrf_conf('rewrite', false);
}

function checkExistIP($ip){
	$handle = fopen("..".BKSEPARATOR."banned.log", 'r');
	$valid = false;
	$line = "";
	while (($buffer = fgets($handle)) !== false) {
		if (strpos($buffer, $ip) !== false) {
			$valid = TRUE;
			$line = $buffer;
			break;
		}
	}
	$return[0] = $valid;
	$return[1] = $line;
	fclose($handle);
	return ($return);
}

include ('anticsrf/csrf-magic.php');

if (!isset($_SESSION['barikode_ninja'])){ 
	include("pages/login.php");
	exit;
} else {
	if (isset($_SESSION['BHTTP_USER_AGENT']))
	{
		if ($_SESSION['BHTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'].':'.$barikode_options['salt']))
		{
			session_destroy();
			include("pages/login.php");
			exit;
		}
	} else {
		session_destroy();
		include("pages/login.php");
		exit;
	}
	
	if (isset($_GET['action'])){
		switch ($_GET['action']) {
			case "delete-ip" :				
				if(isset($_POST['ipdelete'])){
					$valid = filter_var($_POST['ipdelete'], FILTER_VALIDATE_IP);
					if (!$valid) {
						echo "Please fill it with valid IP";
					} else {
						$return = checkExistIP($_POST['ipdelete']);
						if ($return[0]){							
								file_put_contents(
									"..".BKSEPARATOR."banned.log", 
									str_replace($return[1], "", file_get_contents(__DIR__.BKSEPARATOR."..".BKSEPARATOR."banned.log",LOCK_EX)),LOCK_EX);							
							echo "1337";
						} else {
							echo "Error : IP Not found!";							
						}
					}
				}
				break;
			case "delete-white-ip" :				
				if(isset($_POST['ipdelete'])){
					$valid = filter_var($_POST['ipdelete'], FILTER_VALIDATE_IP);
					if (!$valid) {
						echo "Please fill it with valid IP";
					} else {
						if (in_array($valid,$barikode_whitelist_ip)){							
							$new_barikode_whitelist_ip = array_diff($barikode_whitelist_ip, array($valid));
							
							$write = '<?php $barikode_whitelist_ip = array(';
							if ($new_barikode_whitelist_ip){						
								foreach ($new_barikode_whitelist_ip as $bwi):
									$write .= '"'.$bwi.'",';
								endforeach;					
							}							
							$write .= '); ?>';
							@file_put_contents("..".BKSEPARATOR."whitelist.ip.php",$write, LOCK_EX);
							echo "1337";
						} else {
							echo "Error : IP Not found!";							
						}
					}
				}
				break;
			case "delete-ignore-param" :				
				if(isset($_POST['paramdelete'])){
					$valid = barikode_normalize($_POST['paramdelete']);					
					if (in_array($valid,$barikode_ignore_var)){					
						$new_barikode_ignore_var = array_diff($barikode_ignore_var, array($valid));
						
						$write = '<?php $barikode_ignore_var = array(';
						if ($new_barikode_ignore_var){						
							foreach ($new_barikode_ignore_var as $biv):
								$write .= '"'.$biv.'",';
							endforeach;					
						}							
						$write .= '); ?>';
						@file_put_contents("..".BKSEPARATOR."ignore.var.php",$write, LOCK_EX);
						echo "1337";
					} else {
						echo "Error : Parameter not found!";							
					}					
				}
				break;
			case "update-rule" :
				if ((isset($_POST['value'])) and (isset($_POST['row']))){
					$row = $_POST['row'];
					$barikode_rules_list[$row][4]=$_POST['value'];
					
					$write = "<?php".PHP_EOL."\$en_barikode_rules=<<<'EN'".PHP_EOL.serialize($barikode_rules_list).PHP_EOL."EN;".PHP_EOL;
					@file_put_contents("..".BKSEPARATOR."rules.barikode.php",$write, LOCK_EX);
					echo "1337";
				}
				break;
			case "update-enabled" :
				if ((isset($_POST['evalue'])) and (isset($_POST['erow']))){
					$row = $_POST['erow'];
					$barikode_rules_list[$row][5]=$_POST['evalue'];
					
					$write = "<?php".PHP_EOL."\$en_barikode_rules=<<<'EN'".PHP_EOL.serialize($barikode_rules_list).PHP_EOL."EN;".PHP_EOL;
					@file_put_contents("..".BKSEPARATOR."rules.barikode.php",$write, LOCK_EX);
					echo "1337";
				}
				break;
			case "live" :
				$barikode_options['livelog_time'] = time();
				$write = "<?php".PHP_EOL."\$en_barikode_options=<<<'EN'".PHP_EOL.serialize($barikode_options).PHP_EOL."EN;".PHP_EOL;
				@file_put_contents("..".BKSEPARATOR."options.barikode.php",$write, LOCK_EX);
				break;
			default :
				break;
		}
		exit;
	}
	
	include("pages/header.php");
	
	if (isset($_GET['do'])){
		switch ($_GET['do']) {
			case "logout" :
				session_destroy();
				header("location: index.php");
				break;
			case "dashboard" :				
				include("pages/dashboard.php");
				break;
			case "ip" :				
				include("pages/ip.php");
				break;
			case "var" :				
				include("pages/var.php");
				break;
			case "rules" :				
				include("pages/rules.php");
				break;
			case "live" :				
				include("pages/live.php");
				break;
			case "setting" :				
				include("pages/setting.php");
				break;
			case "update" :				
				include("pages/update.php");
				break;
			default :
				break;
		}
	} else {
		include("pages/dashboard.php");
	}
	include("pages/footer.php");
}
?>