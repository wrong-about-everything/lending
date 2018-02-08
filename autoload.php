<?php

spl_autoload_register(
    function ($className) {
        $path = dirname(__FILE__) . '/' . str_replace('\\', '/', $className) . '.php';

        if (!file_exists($path)) {
            return false;
        }

        require_once $path;
    }
);
