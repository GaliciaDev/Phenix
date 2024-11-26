<?php
include_once __DIR__ . '/model.php';

// Función para obtener datos del formulario
function obtenerDatosFormulario($campo) {
    return $_POST[$campo] ?? '';
}

// Función para crear un array con los datos
function crearArrayDatos($datos) {
    return $datos;
}

// Función para convertir el array a JSON
function convertirArrayAJson($data) {
    return json_encode($data, JSON_UNESCAPED_UNICODE);
}

// Función para especificar la ruta donde deseas guardar el archivo JSON
function obtenerRutaArchivoJson($seccion) {
    $target_dir = "/var/www/rxcode/sensihome/cloud/api/data/page/section_$seccion/";
    $timestamp = date("YmdHis");
    return $target_dir . $timestamp . "_backup.json";
}

// Función para crear la carpeta de destino si no existe
function crearCarpetaDestino($ruta) {
    $target_dir = dirname($ruta);
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
}

// Función para guardar el archivo JSON en la ruta especificada
function guardarArchivoJson($ruta, $json_data) {
    file_put_contents($ruta, $json_data);
}

// Función para subir la imagen
function subirImagen($campo, $seccion) {
    if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] == UPLOAD_ERR_OK) {
        $target_dir = "/var/www/rxcode/sensihome/cloud/api/data/page/section_$seccion/";
        $timestamp = date("YmdHis");
        $target_file = $target_dir . $timestamp . "_" . basename($_FILES[$campo]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verificar si el archivo es una imagen real
        $check = getimagesize($_FILES[$campo]["tmp_name"]);
        if($check !== false) {
            // Crear la carpeta de destino si no existe
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            if (move_uploaded_file($_FILES[$campo]["tmp_name"], $target_file)) {
                return "/cloud/api/data/page/section_$seccion/" . $timestamp . "_" . basename($_FILES[$campo]["name"]);
            } else {
                echo "Lo siento, hubo un error al subir tu archivo.";
                return '';
            }
        } else {
            echo "El archivo no es una imagen.";
            return '';
        }
    } else {
        return ''; // No se subió ninguna imagen
    }
}

// Función para actualizar la base de datos
function actualizarBaseDeDatos($con, $json_data, $seccion) {
    $sql = "UPDATE elementos_pagina SET contenido=? WHERE seccion=?";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("ss", $json_data, $seccion);
        if ($stmt->execute()) {
            echo "Los datos han sido actualizados en la base de datos.";
        } else {
            echo "Error al actualizar los datos: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $con->error;
    }
}

// Función para recuperar los datos del JSON desde los archivos
function obtenerDatosJsonDesdeArchivo($seccion) {
    $target_dir = "/var/www/rxcode/sensihome/cloud/api/data/page/section_$seccion/";
    $files = glob($target_dir . "*.json");
    if (!empty($files)) {
        $latest_file = end($files);
        $json_data = file_get_contents($latest_file);
        return json_decode($json_data, true);
    }
    return [];
}

// Verificar la conexión a la base de datos
if (!$con) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Procesar solo si se ha enviado un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener la sección del formulario enviado
    $seccion = $_POST['section'] ?? '';

    if ($seccion) {
        // Definir los campos para cada sección
        $secciones = [
            'section_1' => [
                'titulo' => 'text_title_section1',
                'subtitulo' => 'text_subtitle_section1',
                'precio' => 'text_price_section1',
                'texto' => 'text_text_section1',
                'texto_inferior' => 'text_text_bottom_section1',
                'imagen' => 'file_image_section1',
                'oferta' => 'text_offer_section1'
            ],
            'section_2' => [
                'titulo' => 'text_title_section2'
            ],
            'section_3' => [
                'titulo' => 'text_title_section3',
                'imagen' => 'file_image_section3'
            ],
            'section_4' => [
                'titulo' => 'text_title_section4'
            ],
            'section_5' => [
                'titulo' => 'text_title_section5',
                'texto' => 'text_text_section5',
                'boton' => 'text_button_section5',
                'imagen' => 'file_image_section5'
            ]
        ];

        // Verificar si la sección existe en la configuración
        if (isset($secciones[$seccion])) {
            $datos = [];
            foreach ($secciones[$seccion] as $campo => $nombre_campo) {
                if ($campo === 'imagen') {
                    $datos[$campo] = subirImagen($nombre_campo, substr($seccion, -1));
                } else {
                    $datos[$campo] = obtenerDatosFormulario($nombre_campo);
                }
            }

            // Crear un array con los datos
            $data = crearArrayDatos($datos);

            // Convertir el array a JSON
            $json_data = convertirArrayAJson($data);

            // Especificar la ruta donde deseas guardar el archivo JSON
            $backup_file = obtenerRutaArchivoJson(substr($seccion, -1));

            // Crear la carpeta de destino si no existe
            crearCarpetaDestino($backup_file);

            // Guardar el archivo JSON en la ruta especificada
            guardarArchivoJson($backup_file, $json_data);

            // Mandando información a la tabla
            actualizarBaseDeDatos($con, $json_data, $seccion);

            // Mostrar mensaje de alerta y redirigir
            echo "<script>                    
                    window.location.href = 'https://rxcode.tech/sensihome/wset/panel.php?modulo=editarPagina';
                  </script>";
        } else {
            echo "Sección no válida.";
        }
    } else {
        echo "No se ha enviado ninguna sección.";
    }
}
?>