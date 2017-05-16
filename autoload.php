<?php
function classLoader($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . '/src/' . $path . '.php';
    //print($file."\n");
    if (file_exists($file)) {
        require_once $file;
    }
}
spl_autoload_register('classLoader');
require_once  __DIR__ . '/src/Pandora/Functions.php';