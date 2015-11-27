<?php
namespace Hackathon;

use mysqli;
use TwitterAPIExchange;

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
		if(empty($comment) || empty($source) || empty($link)){
			return false;
		}else{
			$query = "SELECT * FROM data WHERE value = '{$comment}' AND source = '{$source}' AND link = '{$link}'";
			if($this->connection->query($query)){
				return false;
			}else{
				return true;
			}
		}
	}

	public function addData($comment, $source, $link){
		$comment = $this->connection->real_escape_string($comment);
		$source = $this->connection->real_escape_string($source);
		$link = $this->connection->real_escape_string($link);
		$query = "INSERT INTO data (value, timestamp, source, link) VALUES ('{$comment}', CURRENT_TIMESTAMP, '{$source}', '{$link}')";
		
		if($this->validate($comment, $source, $link)){
			return $this->connection->query($query);
		}else{
			return false;
		}
	}

	public function search($search){
		if(!empty($search)){
			$search = $this->connection->real_escape_string($search);
			$query = "SELECT * FROM data";
			$data = array();
			$results = $this->connection->query($query);

			while($row = $results->fetch_assoc()){
				$haystack = implode($row);
				if(strpos($haystack, $search) !== false){
					$data[] = $row; 
				}
			}
		}

		return $data;
	}

	public function getTweets(){
		$settings = array(
		    'oauth_access_token' => "228807675-waeMbDnB0QsMiPdFFrEM1MN6QQGl0WU6KuvJqzo1",
		    'oauth_access_token_secret' => "Z47i6A0jwMFXAYQtRqsqWDc8IORIvCVXEWZQwdNutRY48",
		    'consumer_key' => "VhoWZGUpjA2bAsGUrfD9X61qK",
		    'consumer_secret' => "nH9xzw5sxd1WqdUpKCBfgMwnWGsGHVk2yPjKB6qXF2z8yDTvU5"
		);

		$url = 'https://api.twitter.com/1.1/search/tweets.json';
		$getfield = '?q=%23ovh';
		$requestMethod = 'GET';

		$twitter = new TwitterAPIExchange($settings);
		$tweets = $twitter->setGetfield($getfield)
		             ->buildOauth($url, $requestMethod)
		             ->performRequest();

		$tweets = json_decode($tweets);

		foreach($tweets as $value){
			foreach($value as $tweet){
				if(is_object($tweet)){
					$comment = $tweet->text;
					$source = 'twitter';
					$link = 'https://twitter.com/infowebmaniak/status/'. $tweet->id;
					$this->addData($comment, $source, $link);
				}
			}
		}

		return true;
	}
}
