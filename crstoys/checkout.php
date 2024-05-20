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

$total = 0;
$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
    $total += $row['price'] * $row['quantity'];
}

// Registrar el pedido
$sql = "INSERT INTO orders (user_id, total_amount) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("id", $user_id, $total);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

// Insertar productos del pedido
$sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
foreach ($products as $product) {
    $stmt->bind_param("iii", $order_id, $product['id'], $product['quantity']);
    $stmt->execute();
}
$stmt->close();

// Vaciar el carrito
$sql = "DELETE FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

$conn->close();

header('Location: profile.php');
exit();
?>
