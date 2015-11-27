<?php
	require 'vendor/autoload.php';

	use Hackathon\Database;

	$db = new Database();
	$db->getTweets();
	if($_POST){
		$search = $_POST['search'];

		if($db->search($search)){
			$output = '<div class="alert alert-success" role="alert">Showing results!</div>';
		}else{
			$output = '<div class="alert alert-danger" role="alert">No results found.</div>';
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
			    <input type="text" class="form-control" id="search" name="search" placeholder="Search">
			  </div>
			  <button type="submit" class="btn btn-primary">Search</button>
			  <br/><br/>
			</form>
			<?php
				if($_POST){
					foreach($db->search($search) as $row){
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
				}else{
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
				}
			?>
		</div>
	</div>
</body>
</html>