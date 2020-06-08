<?php
if ($_SERVER['SCRIPT_FILENAME'] == str_replace('\\', '/', __FILE__) ) { 
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\r\n<html><head>\r\n<title>404 Not Found</title>\r\n</head><body>\r\n<h1>Not Found</h1>\r\n<p>The requested URL " . $_SERVER['SCRIPT_NAME'] . " was not found on this server.</p>\r\n</body></html>");
}
if(isset($_POST['username']) and isset($_POST['password'])){	
	$username = barikode_normalize($_POST['username']);
	$password = $_POST['password'];	
	$error = barikode_login($username,$password,$barikode_options);
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dojo Panel</title>

    <link rel="stylesheet" href="assets/css/pure-min.css">
	
	<style>
		body{
		  margin: 0px;
		  padding: 0px;
		  background: #212121;

		}

		h1{
		  color: #A93A03;
		  text-align: center;
		  font-family: "Open Sans",Impact;
		  font-weight: normal;
		  margin: 5% auto 0px;
		}
		
		.form{
		  width: 300px;
		  height: 230px;
		  background: #212121;
		  margin: 20px auto;
		  padding-top: 20px;
		  border-radius: 10px;
		  -moz-border-radius: 10px;
		  -webkit-border-radius: 10px;
		}

		input{
		  display: block;
		  width: 229px;
		  height: 30px;
		  margin: 15px auto;
		  background: #fff;
		  border: 0px;
		  padding: 5px;
		  font-size: 16px;
		   border: 2px solid #fff;
		  transition: all 0.3s ease;
		  border-radius: 5px;
		  -moz-border-radius: 5px;
		  -webkit-border-radius: 5px;
		  color:#0A0A09;
		}

		input:focus{
		  border: 2px solid #A93A03;
		}

		input[type="submit"]{
		  display: block;
		  background: #B09F68;
		  width: 239px;
		  cursor: pointer;
		  color: #fff;
		  border: 0px;
		  margin: auto;
		  border-radius: 5px;
		  -moz-border-radius: 5px;
		  -webkit-border-radius: 5px;
		  font-size: 20px;
		  transition: all 0.3s ease;
		  height:40px;
		}

		input[type="submit"]:hover{
		  background: #AA9452;
		}

		a{
		  text-align: center;
		  font-family: Arial;
		  color: #fff;
		  display: block;
		  margin: 15px auto;
		  text-decoration: none;
		  transition: all 0.3s ease;
		  font-size: 12px;
		}

		a:hover{
		  color: #AA9452;
		}


		::-webkit-input-placeholder {
		   color: gray;
		}

		:-moz-placeholder { /* Firefox 18- */
		   color: gray;  
		}

		::-moz-placeholder {  /* Firefox 19+ */
		   color: gray;  
		}

		:-ms-input-placeholder {  
		   color: gray;  
		}
		
		#canvas{
			width:100%;
			height:700px;
			overflow: hidden;
			position:absolute;
			top:0;
			left:0;
			background-color: #1a1724;               
		}
		.canvas-wrap{
			position:relative;
			
		}
		div.canvas-content{
			position:relative;
			z-index:2000;
			color:#fff;
			text-align:center;
			padding-top:30px;
		}
		.area{
			text-align:center;
			font-size:2em;
			color:#fff;
			letter-spacing: -1px;
			font-weight:100;
			text-transform:uppercase;
			text-shadow:0px 0px 1px #fff,
			  0px 0px 1px #fff;
			margin-top:5%;
		}
		
		.area.active {			
			margin-top:-10px;
		}
		
		.error {
			border: 1px solid;
			margin: 10px 0px;
			padding: 15px 10px 15px 50px;
			color: #D8000C;
			background-color: #FFBABA;
			width: 400px;
			margin: 20px auto;
		}
		
		@media (min-width: 48em) {			
			.form{
			  width: 400px;			  
			}

			input{
			  width: 329px;			  
			}
			
			input[type="submit"]{
			  width: 339px;			  
			}
		}
		
		@media (max-width: 48em) {
			.form{
			  width: 300px;			  
			}

			input{
			  width: 229px;			  
			}
			
			input[type="submit"]{
			  width: 239px;			  
			}
		}
	</style>	
</head> 
<body> 
	
	<section class="canvas-wrap">
            <div class="canvas-content">
                <div class="area">Dojo Panel</div>
				<?php
				if (isset($error)){
				?>
				<div class="error">Wrong Username or Password</div>
				<?php } ?>
				<form class="form" action="" method="POST">
					<input name="username" type="text" placeholder="Username" />
					<input name="password" type="password" placeholder="Password" />
					<input type="submit" value="Login" />
					<a href="https://www.ethic.ninja/">Barikode WAF by Ethic Ninja</a>
				</form> 
				
            </div>
            <div id="canvas" class="gradient"></div>
            
        </section>
        
        <!-- Main library -->
        <script src="assets/js/three.min.js"></script>
      
        <!-- Helpers -->
        <script src="assets/js/projector.js"></script>
        <script src="assets/js/canvas-renderer.js"></script>

        <!-- Visualitzation adjustments -->
        <script src="assets/js/3d-lines-animation.js"></script>

        <!-- Animated background color -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/color.js"></script>
		
		<script>
			$('.area').click(function(){
				$(this).toggleClass('active');
			});
		</script>
</body>
</html>

