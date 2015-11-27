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

	public function addData(){
		$query = "INSERT INTO data (value, timestamp, source, link) VALUES ('Lorem ipsum', CURRENT_TIMESTAMP, 'twitter', 'http://twitter.com/')";
		return $this->connection->query($query);
	}
}
