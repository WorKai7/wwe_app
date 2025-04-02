<?php
require_once(dirname(__FILE__) . '/lib/security.lib.php');
require_once(dirname(__FILE__) . '/lib/myproject.lib.php');
$db = require_once(dirname(__FILE__) . '/lib/mypdo.php');
if (GETPOST('debug') == true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}




$request = strtok($_SERVER["REQUEST_URI"], '?');
$basePath = '/wwe';

$request = str_replace($basePath, '', $request);
$request = parse_url($request, PHP_URL_PATH);
$request = rtrim($request, '/');

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
}
