<?php
namespace Hackathon;

use mysqli;
use TwitterAPIExchange;

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

	private function validate($comment, $source, $link){
		if(!empty($comment) && !empty($source) && !empty($link)){
			$query = "SELECT * FROM data WHERE value = '{$comment}' AND source = '{$source}' AND link = '{$link}'";
			$results = $this->connection->query($query);
			return $results->num_rows === 0;	
		}
		return false;
	}

	public function addData($comment, $source, $link, $timestamp = null){
		$comment = $this->connection->real_escape_string($comment);
		$source = $this->connection->real_escape_string($source);
		$link = $this->connection->real_escape_string($link);
		$query = "INSERT INTO data (value, timestamp, source, link) VALUES ('{$comment}', '{$timestamp}', '{$source}', '{$link}')";

		return $this->validate($comment, $source, $link) ? $this->connection->query($query) : false;
	}

	public function search($string){
		$data = [];
		$results = $this->getAllTweets($string);
		while($row = $results->fetch_assoc()){
			$data = array_merge($data, $this->searchForString($string, $row));
		}
		return $data;
	}

	private function searchForString($needle, $row){
		$data = [];
		$haystack = implode($row);
		if(strpos($haystack, $needle) !== false){
			$data[] = $row; 
		}
		return $data;
	}

	private function getAllTweets($string){
		$string = $this->connection->real_escape_string($string);
		$query = "SELECT * FROM data";
		return $this->connection->query($query);
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
					$timestamp = $tweet->created_at;
					$this->addData($comment, $source, $link, $timestamp);
				}
			}
		}

		return true;
	}
}
