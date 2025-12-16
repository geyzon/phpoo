<?php

namespace App\Controllers;

use App\Classes\Uri;
use App\Classes\Redirect;
use App\Controller\Erro\ErrorController;

class Controller
{
	const NAMESPACE_CONTROLLERS = 'App\\Controllers\\';
	
	const FOLDERS_CONTROLLERS = ['Site', 'Admin'];
	
	const ERROR_CONTROLLER = '\\App\\Controllers\\Erro\\ErrorController';
	
	private $controller;
	
	private $controllerClass;
	
	private $uri;

	public function __construct()
	{
		$this->uri = new Uri();
	}
	
	public function getController()
	{
		$uriArray = $this->uri->getUriArray();
		
		if ($this->uri->emptyUri()) 
		{
			$controllerName = DEFAULT_CONTROLLER;
			$actionName = DEFAULT_ACTION;
		} else 
		{
			$controllerName = $uriArray[1] ?? DEFAULT_CONTROLLER;
			$actionName = $uriArray[2] ?? DEFAULT_ACTION;
		}
		
		$this->controllerClass = self::NAMESPACE_CONTROLLERS;
		
		if (in_array(ucfirst($controllerName), self::FOLDERS_CONTROLLERS)) 
		{
			// Se tem Admin ou Site na URI
			$this->controllerClass .= ucfirst($controllerName) . "\\". ucfirst($actionName) . 'Controller';
			echo "<br>" . $this->controllerClass . "<br>";
			echo "<br>Entrou no primeiro<br>";
		}
		else
		{
			// Se é a raiz do projeto
			$this->controllerClass .= ucfirst($controllerName) . 'Controller';
			echo "<br>" . $this->controllerClass . "<br>";
			echo "<br>Entrou no segundo<br>";
		}		
		
		if (class_exists($this->controllerClass)) 
		{
			$this->controller = new $this->controllerClass();
		} else 
		{
			$errorClass = self::ERROR_CONTROLLER;
			$this->controller = new $errorClass();
		}
		
		return $this->controller;
	}
	
	public function controller()
	{
		$uriArray = $this->uri->getUriArray();
		
		foreach(self::FOLDERS_CONTROLLERS as $folderController)
		{
			echo "<br>" . self::NAMESPACE_CONTROLLERS. $folderController . "<br>";
		}
		return $this->getController();
	}

}