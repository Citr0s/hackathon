<?php
	require 'vendor/autoload.php';

	use Hackathon\Database;

	if($_POST){
		$comment = $_POST['comment'];
		$source = $_POST['source'];
		$link = $_POST['link'];

		$db = new Database();
		if($db->addData($comment, $source, $link)){
			$output = '<div class="alert alert-success" role="alert">Successfulluy added a record!</div>';
		}else{
			$output = '<div class="alert alert-danger" role="alert">Sorry, something went wrong!</div>';
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hackathon</title>
	<?php echo isset($output) ? $output : ''; ?>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<style type="text/css">
		body{
			padding:15px;
		}
	</style>
</head>
<body>
	<div class="row">
		<div class="col-md-12">
			<h1>Feedback</h1>
			<form method="post" action="index.php">
			  <div class="form-group">
			    <label for="comment">Comment</label>
			    <textarea class="form-control" name="comment"></textarea>
			  </div>
			  <div class="form-group">
			    <label for="source">Source</label>
			    <input class="form-control" name="source">
			  </div>
			  <div class="form-group">
			    <label for="link">Link</label>
			    <input class="form-control" name="link">
			  </div>
			  <button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
</body>
</html>