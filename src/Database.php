<?php
namespace Hackathon;

use mysqli;

require_once 'config.php';

class Database
{
	private $connection;

	public function __construct(){
		$this->connect();
	}

	private function connect(){
		$this->connection = new mysqli(host, username, password, database);
	}
}
