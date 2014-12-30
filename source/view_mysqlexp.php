<?php 
//check login
if(empty($USER->username)){
	header( "refresh: 0; url=../../login/index.php" );		//redirect to http://localhost/moodle/login/index.php
	exit(0);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Mysqlexp Editor v1.0</title>
	<meta charset="utf-8">

	<link rel="shortcut icon" href="./pix/icon.gif"/>
 	<link rel="stylesheet" type="text/css" href="./source/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./source/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="./source/css/style.css">
</head>
<body>
	<div class="container-fluid">
  		<div class="row">
  			<div class="col-md-12"><h1>MySQLexp Editor v1.0</h1></div>
		</div>
		<div class="row">
  			<div class="col-md-12">
  				<div for="loading" class="modal"></div>
  			</div>
		</div>
		<div class="row">
  			<div class="col-md-6">
  				<div class="panel panel-default">
  					<div class="panel-heading"><h4>Code</h4></div>
  					<div class="panel-body">
  						<textarea autocomplete="off" class="form-control" id="textareaCode" wrap="logical" rows="20" cols="100%"></textarea>
  					</div>
  				</div>
 			</div>
 			<div class="col-md-6">
  				<div class="panel panel-default">
  					<div class="panel-heading"><h4>Result</h4></div>
  					<div id="status"></div>
  					<div id="result"></div>
  				</div>
 			</div>
		</div>
		<div class="row">
  			<div class="col-md-6 ">
  				<button type="button" id="restoredb" class="btn btn-primary glyphicon glyphicon-tasks"> RestoreDB</button>
  				<button type="button" id="submitcode" class="btn btn-success glyphicon glyphicon-send"> Submit</button>
  				<button type="button" class="btn btn-danger glyphicon glyphicon-refresh"> Reset</button>
  			</div>	
		</div>
	</div>
</body>

<footer>
	<script type="text/javascript" src="./source/js/jquery-2.1.1.min.js"></script>
 	<script type="text/javascript" src="./source/js/bootstrap.min.js"></script>
 	<script type="text/javascript" src="./source/js/script.js"></script>
</footer>
</html>