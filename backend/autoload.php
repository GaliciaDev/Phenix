<?php

require __DIR__ . '/src/Autoload/Autoloader.php';
require __DIR__ . '/src/Utils/PathManager.php';

use App\Autoload\Autoloader;
use App\Utils\PathManager;

// Registrar el autoloader
$autoloader = new Autoloader('App\\', __DIR__ . '/src/');
$autoloader->register();

// Configurar rutas
PathManager::setPath('database', __DIR__ . '../../config/database.json');