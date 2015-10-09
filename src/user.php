<?php

class User
{
	public $username;
	public $password;
	public $firstName;
	public $lastName;

	public function __construct($username, $password, $firstName, $lastName)
	{
		$this->username = $username;
		$this->password = $password;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
   	}
}