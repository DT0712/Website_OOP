<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($class) {

    $folders = [
        '/core/',
        '/controllers/',
        '/models/',
        '/services/',
        '/config/'
    ];

    foreach ($folders as $folder) {
        $file = __DIR__ . $folder . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});