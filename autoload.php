<?php

spl_autoload_register(callback: function ($class_name) {
    $file = __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Classes' . DIRECTORY_SEPARATOR . $class_name . '.php';
    if (file_exists($file)) {
        require_once $file;
    } else {
        echo "File $file not found";
    }
});