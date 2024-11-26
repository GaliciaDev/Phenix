<?php

require 'autoload.php';

use App\Database\DatabaseFactory;
use App\Database\MySQLConnection;

// Registrar tipos de bases de datos
DatabaseFactory::register('mysql', MySQLConnection::class);

// Crear y conectar a la base de datos
$db = DatabaseFactory::create('mysql');
$db->connect();

// Ejecutar una consulta
$result = $db->query('SELECT * FROM accesorios');

// Obtener los resultados
$data = $db->fetch($result);

// Cerrar la conexión
$db->close();

// Imprimir los datos obtenidos
print_r($data);