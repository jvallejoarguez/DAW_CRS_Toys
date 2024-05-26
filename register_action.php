<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Validar entradas
    if (empty($username) || empty($password) || empty($email)) {
        header('Location: register.php?error=empty_fields');
        exit();
    }

    // Comprobar si el usuario ya existe
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header('Location: register.php?error=user_exists');
        exit();
    } else {
        // Insertar el nuevo usuario en la base de datos
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $email);

        if ($stmt->execute()) {
            header('Location: login.php?register=success');
            exit();
        } else {
            header('Location: register.php?error=register_failed');
            exit();
        }
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: register.php?error=invalid_method');
    exit();
}
?>
