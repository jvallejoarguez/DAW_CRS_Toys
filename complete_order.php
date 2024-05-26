<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $name = $_POST['name'];
    $address = $_POST['address'];
    $card = $_POST['card'];
    $expiry = $_POST['expiry'];
    $cvv = $_POST['cvv'];

    // Obtener el total del pedido más reciente
    $sql = "SELECT id FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($order_id);
    $stmt->fetch();
    $stmt->close();

    // Insertar los datos del pedido en la tabla user_orders
    $sql = "INSERT INTO user_orders (order_id, user_id, name, address, card, expiry, cvv) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssss", $order_id, $user_id, $name, $address, $card, $expiry, $cvv);
    $stmt->execute();
    $stmt->close();

    // Redirigir al perfil del usuario
    header('Location: profile.php');
    exit();
} else {
    // Si no se accede por POST, redirigir a la página de pago
    header('Location: payment.php');
    exit();
}
?>
