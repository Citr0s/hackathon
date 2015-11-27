<?php
	require 'vendor/autoload.php';

	use Hackathon\Database;

	$db = new Database();

	var_dump($db->addData());
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hackathon</title>
</head>
<body>
	<h1>Works!</h1>
</body>
</html>