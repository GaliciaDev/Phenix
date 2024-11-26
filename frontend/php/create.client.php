<?php
include 'model.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['name-client-sign'];
    $apellido_paterno = $_POST['last-name1-client-sign'];
    $apellido_materno = $_POST['last-name2-client-sign'];
    $email = $_POST['email-client-sign'];
    $telefono = $_POST['phone-client-sign'];
    $password = password_hash($_POST['password-client-sign'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO clientes (email, pass, nombre, apellido_paterno, apellido_materno, telefono) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("ssssss", $email, $password, $nombre, $apellido_paterno, $apellido_materno, $telefono);
        if ($stmt->execute()) {
            header("Location: ../pages/login.php"); // Redirige al formulario de inicio de sesión
            exit(); // Asegura que el script se detenga después de la redirección
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>