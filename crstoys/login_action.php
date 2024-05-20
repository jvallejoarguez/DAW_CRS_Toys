<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar entradas
    if (empty($username) || empty($password)) {
        echo 'Por favor, rellena todos los campos. Redirigiendo...';
        sleep(1);
        header("Location: login.php");
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

            echo "Inicio de sesión exitoso. Bienvenido, $username. Redirigiendo...";
            sleep(1);
            header("Location: index.php");
            exit();
        } else {
            echo "Contraseña incorrecta. Redirigiendo...";
            sleep(1);
            header("Location: login.php");
            exit();
        }
    } else {
        echo "Usuario no encontrado. Redirigiendo...";
        sleep(1);
        header("Location: login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de solicitud no permitido. Redirigiendo...";
    sleep(1);
    header("Location: login.php");
    exit();
}
?>
