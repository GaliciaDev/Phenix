<?php
include 'model.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email-client-sign-in'];
    $password = $_POST['password-client-sign-in'];

    $sql = "SELECT * FROM clientes WHERE email = ?";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['pass'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['nombre']; // Guardar el nombre del usuario en la sesión
                header("Location: ../");
                exit();
            } else {
                header("Location: ../pages/login.php?error=incorrect_password");
                exit();
            }
        } else {
            header("Location: ../pages/login.php?error=no_account");
            exit();
        }
        $stmt->close();
    }
}
?>