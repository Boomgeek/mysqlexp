<?php
//check login
if(empty($USER->username)){
	header( "refresh: 0; url=../../login/index.php" );		//redirect to http://localhost/moodle/login/index.php
	exit(0);
}
//check question
$question = $_REQUEST["question"];
if(empty($question)){
  echo "Error: question was empty.";
  exit(0);
}
//check unit
$unit = $_REQUEST["unit"];
if(empty($unit)){
  echo "Error: unit was empty.";
  exit(0);
}
//check article
$article = $_REQUEST["article"];
if(empty($article)){
  echo "Error: article was empty.";
  exit(0);
}
//check type
$type = $_REQUEST["type"];
if(empty($type)){
  echo "Error: type was empty.";
  exit(0);
}
else
{
  if(($type != 1) && ($type != 2))
  {
    echo "Error: type is wrong. Only type is 1(while_exp) or 2(after_exp)";
    exit(0);
  }
}
?>

<!DOCTYPE html>
<html>
<head>
 	<title>Send Practice</title>
 	<meta charset="utf-8">

 	<link rel="stylesheet" type="text/css" href="./source/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./source/css/bootstrap-theme.min.css">
</head>
<body>
	<div class="container bs-docs-container">
		<div class="row">
 			<div class="col-md-12" role="main">
				<h1 id="glyphicons" class="page-header">
					<span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> 
					ส่งคำตอบ <?php if($type=="while_exp"){echo "ระหว่างการทดลอง";} else {echo "หลังการทดลอง";} ?> บทที่ <?php echo $unit; ?>
				</h1>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">
							<?php echo $question; ?>
						</h3>
					</div>
					<div class="panel-body">
						<textarea id="answer" class="form-control" rows="10"></textarea>
						<div class="row">
							<div class="col-md-12 text-right">
								<br>
								<button type="button" id="submit" class="btn btn-success">ส่งคำตอบ</button>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
	<details hidden>
		<input type="hidden" id="question" value="<?php echo $question; ?>">
    	<input type="hidden" id="unit" value="<?php echo $unit; ?>">
    	<input type="hidden" id="article" value="<?php echo $article; ?>">
    	<input type="hidden" id="type" value="<?php echo $type; ?>">
  	</details>
</body>
<footer>
	<script type="text/javascript" src="./source/js/jquery-2.1.1.min.js"></script>
 	<script type="text/javascript" src="./source/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./source/js/practice.js"></script>
</footer>
</html>