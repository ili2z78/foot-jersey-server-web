<?php
session_start();
$helpers = __DIR__ . '/../app/Helpers/auth.php';
if (file_exists($helpers)) {
    require_once $helpers;
}

require_once __DIR__ . '/../config/database.php';
spl_autoload_register(function($class) {
    $paths = [
        __DIR__ . '/../app/Controllers/' . $class . '.php',
        __DIR__ . '/../app/Models/' . $class . '.php'
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

$controllerName = ucfirst($page) . 'Controller';

if (!class_exists($controllerName)) {
    echo "Controller introuvable : " . $controllerName;
    exit;
}

$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    echo "Action introuvable : " . $action;
    exit;
}

if (isset($_GET['id'])) {
    $controller->$action($_GET['id']);
} else {
    $controller->$action();
}
