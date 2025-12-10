<?php

namespace App\Classes;

class Uri
{
	private $uri;
	
	public function __construct()
	{
		$this->uri = $_SERVER["REQUEST_URI"];
	}
	
	public function getUri()
	{
		return $this->uri;
	}
	
	public function emptyUri()
	{
		return empty($this->uri) || $this->uri === '/';
	}
	
	public function getUriArray()
	{
		return explode('/', $this->uri);
	}
}