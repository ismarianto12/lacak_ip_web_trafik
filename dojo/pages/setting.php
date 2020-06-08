<?php
if ($_SERVER['SCRIPT_FILENAME'] == str_replace('\\', '/', __FILE__) ) { 
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\r\n<html><head>\r\n<title>404 Not Found</title>\r\n</head><body>\r\n<h1>Not Found</h1>\r\n<p>The requested URL " . $_SERVER['SCRIPT_NAME'] . " was not found on this server.</p>\r\n</body></html>");
}
	if(isset($_POST['change'])){
		$barikode_options['rss'] = $_POST['protection'];
		$barikode_options['banned_message'] = $_POST['banned_message'];
		$barikode_options['email'] = $_POST['email'];
		$barikode_options['minbanned'] = $_POST['minbanned'];
		$barikode_options['minreport'] = $_POST['minreport'];
		$barikode_options['time_banned'] = $_POST['time_banned'];
		$barikode_options['upload_check_ext'] = $_POST['upload_check_ext'];
		$barikode_options['upload_check_elf'] = $_POST['upload_check_elf'];
		$barikode_options['upload_check_script'] = $_POST['upload_check_script'];
		$barikode_options['smtp_host'] = $_POST['smtp_host'];
		$barikode_options['smtp_port'] = $_POST['smtp_port'];         
		$barikode_options['smtp_username'] = $_POST['smtp_username'];
		$barikode_options['smtp_password'] = barikode_encode($_POST['smtp_password']);
		$write = "<?php".PHP_EOL."\$en_barikode_options=<<<'EN'".PHP_EOL.serialize($barikode_options).PHP_EOL."EN;".PHP_EOL;
		@file_put_contents("..".BKSEPARATOR."options.barikode.php",$write, LOCK_EX);
	}
	
	if (isset($_POST['passchange'])){
		if ($_POST['new']==$_POST['new2']){
			$return = barikode_changePassword($_POST['old'],$_POST['new'],$barikode_options);
		} else {
			$return = "Wrong confirm password";
		}
	}
?>
<div id="main">
	<div class="header">
		<h1>General Setting</h1>
		<h2>Your wish is my command!</h2>
	</div>
	
	<div class="content">	
		
		<h2 class="content-subhead">Options Setting</h2>
		
		<form class="pure-form pure-form-aligned" method="post" action="">
		<input type="hidden" name="change" value="1"/>
		<fieldset>
			<div class="pure-control-group">
				<label for="protection">Barikode WAF Protection</label>
				<select id="protection" name="protection" class="form-control">
				  <option value="1" <?php if ($barikode_options['rss']==1) echo 'selected';?>>Enable</option>
				  <option value="0" <?php if ($barikode_options['rss']==0) echo 'selected';?>>Disable</option>
				</select>
			</div>

			<div class="pure-control-group">
				<label for="banned_message" style="vertical-align:top;">IP Blocked Message</label>
				<textarea name="banned_message" id="banned_message" width=10><?php if ($barikode_options['banned_message']) echo $barikode_options['banned_message'];?></textarea>
				<script src="./assets/ckeditor_lite/ckeditor.js" type="text/javascript"></script>
				<script>
					CKEDITOR.replace( 'banned_message' );
				</script>
			</div>

			<div class="pure-control-group">
				<label for="email">Admin Email Address</label>
				<input name="email" type="email" placeholder="Email Address" value="<?php if ($barikode_options['email']) echo $barikode_options['email'];?>">
			</div>

			<div class="pure-control-group">
				<label for="upload_check_ext">Block uploaded file system (.php,.phtml,.exe, etc)</label>
				<select id="upload_check_ext" name="upload_check_ext" class="form-control">
				  <option value="1" <?php if ($barikode_options['upload_check_ext']==1) echo 'selected';?>>Yes</option>
				  <option value="0" <?php if ($barikode_options['upload_check_ext']==0) echo 'selected';?>>No</option>
				</select>
			</div>
			
			<div class="pure-control-group">
				<label for="upload_check_elf">Block uploaded elf file</label>
				<select id="upload_check_elf" name="upload_check_elf" class="form-control">
				  <option value="1" <?php if ($barikode_options['upload_check_elf']==1) echo 'selected';?>>Yes</option>
				  <option value="0" <?php if ($barikode_options['upload_check_elf']==0) echo 'selected';?>>No</option>
				</select>
			</div>
			
			<div class="pure-control-group">
				<label for="upload_check_script">Block uploaded file contain suspicious script</label>
				<select id="upload_check_script" name="upload_check_script" class="form-control">
				  <option value="1" <?php if ($barikode_options['upload_check_script']==1) echo 'selected';?>>Yes</option>
				  <option value="0" <?php if ($barikode_options['upload_check_script']==0) echo 'selected';?>>No</option>
				</select>
			</div>
			
			<div class="pure-control-group">
				<label for="time_banned">Temporary IP Blocked Time (minute)</label>
				<input name="time_banned" type="text" placeholder="ex: 10" value="<?php if ($barikode_options['time_banned']) echo $barikode_options['time_banned'];?>">
			</div>

			<div class="pure-control-group">
				<label for="minbanned">IP Blocked for : </label>
				<select name="minbanned">
					<option value="5" <?php if ($barikode_options['minbanned']==5) echo 'selected';?>>Debug (No Blocked)</option>
					<option value="1" <?php if ($barikode_options['minbanned']==1) echo 'selected';?>>Low + Medium + High Risk Attack</option>
				    <option value="2" <?php if ($barikode_options['minbanned']==2) echo 'selected';?>>Medium + High Risk Attack</option>
				    <option value="3" <?php if ($barikode_options['minbanned']==3) echo 'selected';?>>High Risk Attack</option>
				</select>
			</div>
			
			<div class="pure-control-group">
				<label for="minreport">Send instant attack report for</label>
				<select name="minreport">
					<option value="5" <?php if ($barikode_options['minreport']==0) echo 'selected';?>>Dont Send</option>
					<option value="1" <?php if ($barikode_options['minreport']==1) echo 'selected';?>>Low + Medium + High Risk Attack</option>
				    <option value="2" <?php if ($barikode_options['minreport']==2) echo 'selected';?>>Medium + High Risk Attack</option>
				    <option value="3" <?php if ($barikode_options['minreport']==3) echo 'selected';?>>High Risk Attack</option>
				</select>
			</div>
			
			<div class="pure-controls">	
				<button type="submit" class="pure-button pure-button-primary">Submit</button>
			</div>
			
			<p><b>If you have your own SMTP, you can setup here :</b></p>
			
			<div class="pure-control-group">
				<label for="smtp_host">SMTP Host</label>
				<input name="smtp_host" type="text" placeholder="ex: smtp.gmail.com" value="<?php if ($barikode_options['smtp_host']) echo $barikode_options['smtp_host'];?>">
			</div>
			
			<div class="pure-control-group">
				<label for="smtp_port">SMTP Port</label>
				<input name="smtp_port" type="text" placeholder="ex: 465" value="<?php if ($barikode_options['smtp_port']) echo $barikode_options['smtp_port'];?>">
			</div>
			
			<div class="pure-control-group">
				<label for="smtp_username">SMTP Username</label>
				<input name="smtp_username" type="text" placeholder="ex: mycompany@gmail.com" value="<?php if ($barikode_options['smtp_username']) echo $barikode_options['smtp_username'];?>">
			</div>
			
			<div class="pure-control-group">
				<label for="smtp_password">SMTP Password</label>
				<input name="smtp_password" type="password" value="<?php if ($barikode_options['smtp_password']) echo barikode_decode($barikode_options['smtp_password']);?>">
			</div>
			
			<div class="pure-controls">	
				<button type="submit" class="pure-button pure-button-primary">Submit</button>
			</div>
		</fieldset>
		</form>
		
		<h2 class="content-subhead">Change Barikode WAF Password</h2>
		
		<form class="pure-form pure-form-aligned" method="post" action="">
			<?php
			if (isset($return)){
				if ($return !== "1337"){
					echo '<div class="msg-error">'.$return.'</div>';
				} else {
					echo '<div class="msg-success">Succesfully change password!</div>';
				}
			} ?>
			<fieldset>
				<div class="pure-control-group">
					<label for="old">Old Password</label>
					<input name="old" type="password" required>
				</div>
				
				<div class="pure-control-group">
					<label for="new">New Password</label>
					<input name="new" type="password" required>
				</div>
				
				<div class="pure-control-group">
					<label for="new2">Confirm New Password</label>
					<input name="new2" type="password" required>
				</div>
				<div class="pure-controls">	
					<input type="hidden" name="passchange" value="pass"/>
					<button type="submit" class="pure-button pure-button-primary">Submit</button>
				</div>
			</fieldset>
		</form>			
	</div>
</div>