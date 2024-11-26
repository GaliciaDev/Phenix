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

// Verificar si se ha subido un archivo
if (!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] != UPLOAD_ERR_OK) {
    die("Error al subir el archivo.");
}

// Generar un nombre aleatorio para la imagen utilizando la fecha y hora de subida
$timestamp = date("YmdHis");
$random_name = $timestamp . "_" . basename($_FILES["imagen"]["name"]);
$target_file = $target_dir . $random_name;
$relative_file = $relative_dir . $random_name;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Verificar si el archivo es una imagen real
$check = getimagesize($_FILES["imagen"]["tmp_name"]);
if($check !== false) {
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        // Conectar a la base de datos
        $conn = new mysqli("localhost", "u224160417_sensi_auth", "n4=x!E8]p2NQ", "u224160417_dev_model");

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Crear un array con los datos del formulario
        $data = array(
            "oferta" => $_POST['oferta'] ?? '',
            "imagen" => $relative_file,
            "titulo" => $_POST['titulo'] ?? '',
            "subtitulo" => $_POST['subtitulo'] ?? '',
            "precio" => $_POST['precio'] ?? '',
            "descripcion" => $_POST['descripcion'] ?? '',
            "texto_inferior" => $_POST['texto_inferior'] ?? '',
            "texto" => $_POST['texto'] ?? ''
        );

        // Convertir el array a JSON
        $json_data = json_encode($data, JSON_UNESCAPED_UNICODE);

        // Guardar el JSON de respaldo en la carpeta de destino
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
    } else {
        echo "Lo siento, hubo un error al subir tu archivo. Error: " . $_FILES["imagen"]["error"];
    }
} else {
    echo "El archivo no es una imagen. Error: " . $_FILES["imagen"]["error"];
}
?>