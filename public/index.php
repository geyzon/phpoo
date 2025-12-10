<?php
// router.php
print_r($_SERVER["REQUEST_URI"]);
if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // serve o recurso requisitado sem modificação.
} else {
    session_start();
	
	define('DEFAULT_CONTROLLER', 'Home');
	define('DEFAULT_ACTION', 'index');
	
	require_once __DIR__ . '/../vendor/autoload.php';
	require_once __DIR__ . '/../src/Functions/functions_twig.php';
	require_once __DIR__ . '/bootstrap/bootstrap.php';
}
?>