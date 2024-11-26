<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$target_dir_base = "/var/www/rxcode/sensihome/cloud/api/data/page/section_";
$relative_dir_base = "cloud/api/data/page/section_";

// Obtener la sección desde el formulario
$seccion = $_POST['seccion'] ?? '';
if (empty($seccion)) {
    die("Sección no especificada.");
}

$target_dir = $target_dir_base . $seccion . "/";
$relative_dir = $relative_dir_base . $seccion . "/";

// Crear la carpeta de destino si no existe
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Conectar a la base de datos
$conn = new mysqli("localhost", "u224160417_sensi_auth", "n4=x!E8]p2NQ", "u224160417_dev_model");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear un array con los datos del formulario
$data = array(
    "titulo" => $_POST['titulo'] ?? ''
);

// Convertir el array a JSON
$json_data = json_encode($data, JSON_UNESCAPED_UNICODE);

// Guardar el JSON de respaldo en la carpeta de destino
$timestamp = date("YmdHis");
$backup_file = $target_dir . $timestamp . "_backup.json";
file_put_contents($backup_file, $json_data);

// Preparar y ejecutar la consulta de actualización
$sql = "UPDATE elementos_pagina SET contenido='$json_data' WHERE seccion='section_$seccion'";
if ($conn->query($sql) === TRUE) {
    echo "Los datos han sido actualizados en la base de datos.";
} else {
    echo "Error al actualizar la base de datos: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>