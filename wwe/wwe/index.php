<?php

require_once(dirname(__FILE__) . '/class/myAuthClass.php');
require_once(dirname(__FILE__) . '/lib/myproject.lib.php');
$db = require_once(dirname(__FILE__) . '/lib/mypdo.php');
if (GETPOST('debug') == true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

$authenticated = myAuthClass::is_auth($_SESSION);

$routes_publiques = [
    "/login",
    "/register"
];

$request = strtok($_SERVER["REQUEST_URI"], '?');
$basePath = '/wwe';

$request = str_replace($basePath, '', $request);
$request = parse_url($request, PHP_URL_PATH);
$request = rtrim($request, '/');

if (!in_array($request, $routes_publiques)) {
    if (!$authenticated) {
        header("Location:/wwe/login");
        exit(1);
    }
} else {
    if ($authenticated) {
        header("Location:/wwe");
        exit(1);
    }
}

if ($request == "" || $request == "/") {
    include __DIR__.'/views/home.php';
    exit();
}

$controller = __DIR__."/controllers/$request.php";
$view = __DIR__."/views/$request.php";

if (file_exists($controller)) {
    include $controller;
}

if (file_exists($view)) {
    include $view;
}

if (!file_exists($view) && !file_exists($controller)) {
    include __DIR__.'/inc/notfound.php';
}