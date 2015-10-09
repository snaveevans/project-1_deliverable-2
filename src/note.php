<?php

class Note
{
	public $id;
	public $name;
	public $body;
	public $username;
	public $tags;

	public function __construct($id, $name, $body, $username, $tags)
	{
		$this->id = $id;
		$this->name = $name;
		$this->body = $body;
		$this->username = $username;
		$this->tags = $tags;
	}
}