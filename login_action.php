<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar entradas
    if (empty($username) || empty($password)) {
        header('Location: login.php?error=empty_fields');
        exit();
    }

    // Buscar el usuario en la base de datos
    $stmt = $conn->prepare("SELECT id, username, password, is_admin FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password, $is_admin);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $hashed_password)) {
            // Iniciar sesión
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = $is_admin;

            header('Location: index.php?login=success');
            exit();
        } else {
            header('Location: login.php?error=wrong_password');
            exit();
        }
    } else {
        header('Location: login.php?error=user_not_found');
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: login.php?error=invalid_method');
    exit();
}
?>
