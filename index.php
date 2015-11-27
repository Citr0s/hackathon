<?php
	require 'vendor/autoload.php';

	use Hackathon\Database;

	//if($_POST){
		// $comment = $_POST['comment'];
		// $source = $_POST['source'];
		// $link = $_POST['link'];

		$db = new Database();
		// if($db->addData($comment, $source, $link)){
		// 	$output = '<div class="alert alert-success" role="alert">Successfulluy added a record!</div>';
		// }else{
		// 	$output = '<div class="alert alert-danger" role="alert">All fields are required.</div>';
		// }

		var_dump($db->getTweets());
	//}

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
			<?php
				$connection = new mysqli(host, username, password, database);
				$results = $connection->query("SELECT * FROM data ORDER BY id DESC");

				while($row = $results->fetch_assoc()){
					echo '
					<div class="panel panel-default">
					  <div class="panel-body">
					    <tr>
							<td><a target="_blank" href="'. $row['link'] .'">'. $row['id'] .'</a></td>
							<td>'. $row['value'] .'</td>
							<td>'. $row['timestamp'] .'</td>
							<td>'. $row['source'] .'</td>
						</tr>
					  </div>
					</div>
					';
				}
			?>
		</div>
	</div>
</body>
</html>