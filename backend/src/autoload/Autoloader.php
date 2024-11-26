<?php

namespace App\Autoload;

class Autoloader
{
    protected $prefix;
    protected $baseDir;

    public function __construct($prefix, $baseDir)
    {
        $this->prefix = $prefix;
        $this->baseDir = $baseDir;
    }

    public function register()
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    public function loadClass($class)
    {
        $len = strlen($this->prefix);

        if (strncmp($this->prefix, $class, $len) !== 0) {
            return;
        }

        $relative_class = substr($class, $len);
        $file = $this->baseDir . str_replace('\\', '/', $relative_class) . '.php';

        if (file_exists($file)) {
            require $file;
        }
    }
}