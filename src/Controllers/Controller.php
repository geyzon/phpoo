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
		
		if ($this->uri->emptyUri()) {
			$controllerName = DEFAULT_CONTROLLER;
			$actionName = DEFAULT_ACTION;
		} else {
			$controllerName = $uriArray[1] ?? DEFAULT_CONTROLLER;
			$actionName = $uriArray[2] ?? DEFAULT_ACTION;
		}
		
		$controllerClass = self::NAMESPACE_CONTROLLERS;
		
		if (in_array(ucfirst($controllerName), self::FOLDERS_CONTROLLERS)) {
			$controllerClass .= ucfirst($actionName) . 'Controller';
		} else {
			$controllerClass .= 'Site\\' . ucfirst($controllerName) . 'Controller';
		}
		
		if (class_exists($controllerClass)) {
			$this->controller = new $controllerClass();
		} else {
			$errorClass = self::ERROR_CONTROLLER;
			$this->controller = new $errorClass();
		}
		
		return $this->controller;
	}

}