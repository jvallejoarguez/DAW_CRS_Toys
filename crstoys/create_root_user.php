<?php
include 'db.php';

// Datos del usuario root
$username = 'root';
$email = 'root@example.com';
$password = 'root';
$is_admin = 1;

// Hashear la contraseña
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insertar el usuario root en la base de datos
$stmt = $conn->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $username, $email, $hashed_password, $is_admin);

if ($stmt->execute()) {
    echo "Usuario root creado exitosamente.";
} else {
    echo "Error al crear el usuario root: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
