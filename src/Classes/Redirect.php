<?php

namespace App\Classes;

class Redirect
{
	public function redirect($redirect = null)
	{
		if ($redirect) {
			header("Location: " . $redirect);
			exit;
		}
		
		return header("Location: /");
	}
}