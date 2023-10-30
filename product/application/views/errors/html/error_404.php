<!--<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
</body>
</html>-->

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$ci = new CI_Controller();
$ci =& get_instance();
$ci->load->helper('url');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<link href='http://fonts.googleapis.com/css?family=Amarante' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" href="<?=base_url('assets/images/soppia.png')?>">
<style type="text/css">
body{
    background:blue;
    margin:0;
    color:#fff;
}
.wrap{
    margin:0 auto;
    width:1000px;
}
.logo{
    text-align:center;
}   
.logo p span{
    color:lightgreen;
}   
.sub a{
    color:white;
    background:rgba(0,0,0,0.3);
    text-decoration:none;
    padding:5px 10px;
    font-size:13px;
    font-family: arial, serif;
    font-weight:bold;
}   
.footer{
    color:#555;
    position:absolute;
    right:10px;
    bottom:10px;
    font-weight:bold;
    font-family:arial, serif;
}   
.footer a{
    font-size:16px;
    color:#ff4800;
}   
</style>
</head>
<body> 
    <div class="wrap">
    	<center>
    		<h2 style="font-size:45px">4 0 4</h2>
          	<h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
    		<br/>
    		<br/>
    		<br/>
    	</center>
       <div class="logo">
               <div class="sub">
                 <p><a href="<?php echo base_url("dashboard"); ?>">Go Back?</a></p>
               </div>
        </div>
     </div>
</body>
</html>