<?php
namespace Hackathon;

use mysqli;

require_once 'config.php';

/*
	CREATE TABLE data ( id int NOT NULL AUTO_INCREMENT, value  text, timestamp varchar(50), source varchar(255), link varchar(255), PRIMARY KEY (id));
	INSERT INTO data (value, timestamp, source, link) VALUES ('Lorem ipsum', CURRENT_TIMESTAMP, 'twitter', 'http://twitter.com/');
*/

class Database
{
	private $connection;

	public function __construct(){
		$this->connect();
	}

	private function connect(){
		$this->connection = new mysqli(host, username, password, database);
	}

	private function validate($comment, $source, $link){
		var_dump($comment, $source, $link);
		if(empty($comment) || empty($source) || empty($link)){
			return false;
		}else{
			return true;
		}
	}

	public function addData($comment, $source, $link){
		$query = "INSERT INTO data (value, timestamp, source, link) VALUES ('{$comment}', CURRENT_TIMESTAMP, '{$source}', '{$link}')";
		
		if($this->validate($comment, $source, $link)){
			return $this->connection->query($query);
		}else{
			return false;
		}
	}
}
