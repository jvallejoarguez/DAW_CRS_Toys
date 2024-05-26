<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Obtener productos del carrito
$sql = "SELECT p.id, p.price, c.quantity FROM products p JOIN cart c ON p.id = c.product_id WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total_amount = 0;
while ($row = $result->fetch_assoc()) {
    $total_amount += $row['price'] * $row['quantity'];
}

// Registrar el pedido
$sql = "INSERT INTO orders (user_id, total_amount) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("id", $user_id, $total_amount);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

// Insertar productos del pedido en la tabla order_items
$sql = "INSERT INTO order_items (order_id, product_id, quantity) SELECT ?, product_id, quantity FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$stmt->close();

// Vaciar el carrito
$sql = "DELETE FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

header("Location: payment.php");
exit();
?>
