<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Validar entradas
    if (empty($username) || empty($password) || empty($email)) {
        echo 'Por favor, rellena todos los campos. Redirigiendo...';
        sleep(1);
        header("Location: register.php");
        exit();
    }

    // Comprobar si el usuario ya existe
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo 'El nombre de usuario ya está en uso. Redirigiendo...';
        sleep(1);
        header("Location: register.php");
        exit();
    } else {
        // Insertar el nuevo usuario en la base de datos
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $email);

        if ($stmt->execute()) {
            echo "Registro exitoso. Redirigiendo...";
            sleep(1);
            header("Location: login.php");
            exit();
        } else {
            echo "Error en el registro. Por favor, inténtalo de nuevo. Redirigiendo...";
            sleep(1);
            header("Location: register.php");
            exit();
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de solicitud no permitido. Redirigiendo...";
    sleep(1);
    header("Location: register.php");
    exit();
}
?>
