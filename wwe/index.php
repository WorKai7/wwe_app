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

switch ($request) {
    case '':
    case '/':
        include __DIR__.'/views/home.php';
        break;

    case '/stats':
        include __DIR__.'/views/stats.php';
        break;

    case '/analysis':
        include __DIR__.'/views/analysis.php';
        break;
    
    case '/register':
        include __DIR__.'/controllers/register.php';
        include __DIR__.'/views/register.php';
        break;

    case '/login':
        include __DIR__.'/views/login.php';
        break;
    
    case '/data':
        include __DIR__.'/views/data.php';
        break;
    
    default:
        include __DIR__.'/inc/notfound.php';
        break;
}
