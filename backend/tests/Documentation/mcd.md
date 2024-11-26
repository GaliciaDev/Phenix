Metodos de consulta, documentacion

<?php

require 'autoload.php';

use App\Database\DatabaseFactory;
use App\Database\MySQLConnection;

// Registrar tipos de bases de datos
DatabaseFactory::register('mysql', MySQLConnection::class);

// Crear y conectar a la base de datos
$db = DatabaseFactory::create('mysql');
$db->connect();

// Insertar datos
$insertData = [
    'column1' => 'value1',
    'column2' => 'value2'
];
$insertId = $db->insert('your_table', $insertData);
echo "Inserted record with ID: $insertId\n";

// Actualizar datos
$updateData = [
    'column1' => 'new_value1'
];
$where = "id = ?";
$affectedRows = $db->update('your_table', $updateData, $where);
echo "Updated $affectedRows record(s)\n";

// Ejecutar una consulta
$result = $db->query('SELECT * FROM your_table');

// Obtener los resultados
$data = $db->fetch($result);

// Cerrar la conexión
$db->close();

// Imprimir los datos obtenidos
print_r($data);