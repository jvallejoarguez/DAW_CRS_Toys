<?php
session_start();
include 'header.php';
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Obtener productos del carrito
$sql = "SELECT p.id, p.name, p.description, p.price, p.image, c.quantity FROM products p JOIN cart c ON p.id = c.product_id WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
?>

<h2>Carrito de Compras</h2>
<div class="cart">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="cart-item">
            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <p>Precio: €<?php echo htmlspecialchars($row['price']); ?></p>
            <p>Cantidad: <?php echo htmlspecialchars($row['quantity']); ?></p>
            <p>Total: €<?php echo htmlspecialchars($row['price'] * $row['quantity']); ?></p>
        </div>
        <?php $total += $row['price'] * $row['quantity']; ?>
    <?php endwhile; ?>
</div>

<h3>Total: €<?php echo $total; ?></h3>
<a href="payment.php" class="checkout-button">Proceder al Pago</a>

<?php
$stmt->close();
$conn->close();
include 'footer.php';
?>
