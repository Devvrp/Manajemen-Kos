<?php

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            $baseDir = __DIR__ . '/../';
            $folders = [
                'Core/',
                'Controllers/',
                'Models/',
                'Helpers/'
            ];
            $classFile = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            foreach ($folders as $folder) {
                $file = $baseDir . $folder . $classFile;
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
        });
    }
}