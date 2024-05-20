<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id'];

// Verificar si el producto ya está en el carrito
$sql = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Si el producto ya está en el carrito, incrementar la cantidad
    $stmt->bind_result($quantity);
    $stmt->fetch();
    $quantity++;
    $stmt->close();

    $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $quantity, $user_id, $product_id);
} else {
    // Si el producto no está en el carrito, añadirlo
    $stmt->close();
    $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
}

$stmt->execute();
$stmt->close();
$conn->close();

header('Location: cart.php');
exit();
?>
