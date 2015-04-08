<?php 
//check login
if(empty($USER->username)){
	header( "refresh: 0; url=../../login/index.php" );		//redirect to http://localhost/moodle/login/index.php
	exit(0);
}
  $unit = (int)$_REQUEST["unit"];
  if(empty($unit))
  {
    echo "Error: unit was empty";
    exit(0);
  }
  else if(!is_numeric($unit))
  {
    echo "Error: unit is wrong. Unit only is integer.";
    exit(0);
  } 

  $article = (int)$_REQUEST["article"];
  if(empty($article))
  {
    echo "Error: article was empty";
    exit(0);
  }
  else if(!is_numeric($article))
  {
    echo "Error: article is wrong. Article only is integer.";
    exit(0);
  }   

  $type = (int)$_REQUEST["type"];
  if(empty($type))
  {
    echo "Error: type was empty";
    exit(0);
  }
  else if(($type !== 1) && ($type !== 2))
  {
    echo "Error: type is wrong. Only type is 1(while_exp) or 2(after_exp)";
    exit(0);
  }
?>

<!DOCTYPE html>
<html lang="en">
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
  			<div class="col-md-10"><h1>MySQLexp Editor v1.0</h1></div>
        <div class="col-md-2 text-right restore-btn"><button type="button" id="restoredb" class="btn btn-danger glyphicon glyphicon-list"> RestoreDB</button></div>
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
              <div class="text-right">
                <span class="btn-clipboard" id="copy-button" data-clipboard-target="textareaCode" data-toggle="tooltip" data-placement="left" title="Copy to clipboard">Copy</span>
              </div>
  						<textarea autocomplete="off" class="form-control" id="textareaCode" wrap="logical" rows="19" cols="100%"></textarea>
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
  				<button type="button" id="refreshBtn" class="btn btn-primary glyphicon glyphicon-refresh"> Refresh</button>
          <button type="button" id="submitcode" class="btn btn-success glyphicon glyphicon-send"> Submit</button>
  			</div>	
		</div>
	</div>
  <details hidden>
    <input type="hidden" id="unit" value="<?php echo $unit; ?>">
    <input type="hidden" id="article" value="<?php echo $article; ?>">
    <input type="hidden" id="type" value="<?php echo $type; ?>">
  </details>
</body>
<footer>
	<script type="text/javascript" src="./source/js/jquery-2.1.1.min.js"></script>
 	<script type="text/javascript" src="./source/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="./source/js/zeroclipboard/dist/ZeroClipboard.min.js"></script>
 	<script type="text/javascript" src="./source/js/mysqlexp.js"></script>
</footer>
</html>