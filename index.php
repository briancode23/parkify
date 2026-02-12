<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");


session_start();

/**
 * BOOTSTRAP
 */
require_once 'config/config.php';
require_once 'core/Controller.php';
require_once 'core/Database.php';
require_once 'app/controllers/ErrorController.php';
/**
 * PARSE URL
 */
$url = $_GET['url'] ?? 'home/index';
$url = rtrim($url, '/');

if($url === '') {
        $url = 'home/index';
}

$url = explode('/', $url);

if (!preg_match('/^[a-zA-Z0-9_]+$/', $url[0])) {
    handleError(404);
}

/**
 * CONTROLLER & METHOD
 */
$controllerName = ucfirst($url[0]) . 'Controller';
$method = $url[1] ?? 'index';
$params = array_slice($url, 2);

/**
 * CONTROLLER FILE
 */
$controllerFile = 'app/controllers/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    handleError(404);
    // die("Controller <b>$controllerName</b> tidak ditemukan");
}

require_once $controllerFile;

/**
 * CONTROLLER CLASS
 */
if (!class_exists($controllerName)) {
    handleError(405);
    // die("Class <b>$controllerName</b> tidak ada");
}

$controller = new $controllerName();

/**
 * METHOD CHECK
 */
if (!method_exists($controller, $method)) {
    handleError(404);
    // die("Method <b>$method</b> tidak ditemukan di $controllerName");
    
}

/**
 * SECURITY: HANYA PUBLIC METHOD
 */
$reflection = new ReflectionMethod($controller, $method);
if (!$reflection->isPublic()) {
    handleError(405);
    // die("Akses ke method <b>$method</b> ditolak");
}

if (str_starts_with($method, '__')) {
    handleError(405);
}


/**
 * EKSEKUSI
 */
call_user_func_array([$controller, $method], $params);
