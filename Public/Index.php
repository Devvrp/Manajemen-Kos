<?php

require_once __DIR__ . '/../App/Core/Autoloader.php';
Autoloader::register();

$controllerName = isset($_GET['c']) ? ucfirst($_GET['c']) . 'Controller' : 'HomeController';
$actionName = isset($_GET['a']) ? $_GET['a'] : 'index';

$controllerFile = __DIR__ . '/../App/Controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerName) && method_exists($controllerName, $actionName)) {
        $controller = new $controllerName();
        $controller->$actionName();
    } else {
        echo "Error: Class or method not found.";
    }
} else {
    echo "Error: Controller file not found.";
}