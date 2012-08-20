<?php

namespace LibvirtAdmin;

class Autoloader
{

    public static function register()
    {
        spl_autoload_extensions('.php');
        spl_autoload_register(array('LibvirtAdmin\Autoloader', 'load'));
    }

    public static function load($className)
    {
        $className = ltrim($className, '\\');
        $fileName = '';
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        require_once $fileName;
    }

}