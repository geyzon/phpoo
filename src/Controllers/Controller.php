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
		
		$controllerClass = self::NAMESPACE_CONTROLLERS;
		
		if (in_array(ucfirst($controllerName), self::FOLDERS_CONTROLLERS)) 
		{
			$controllerClass .= ucfirst($controllerName) . '\\' . ucfirst($actionName) . 'Controller';
			echo "<br>" . $controllerClass . "<br>";
			echo "<br>Entrou no primeiro<br>";
		}
		else
		{
			$controllerClass .= ucfirst($controllerName) . 'Controller';
			echo "<br>" . $controllerClass . "<br>";
			echo "<br>Entrou no segundo<br>";
		}		
			
		
		
		if (class_exists($controllerClass)) 
		{
			$this->controller = new $controllerClass();
		} else 
		{
			$errorClass = self::ERROR_CONTROLLER;
			$this->controller = new $errorClass();
		}
		
		return $this->controller;
	}
	
	public function controller()
	{
		$controller = $this->getController();
		
		foreach(self::FOLDERS_CONTROLLERS as $folderController)
		{
			if (class_exists(self::NAMESPACE_CONTROLLERS.$folderController.'\\'.$controller))
			{
				return self::NAMESPACE_CONTROLLERS.$folderController.'\\'.$controller;
			}
		}
	}

}