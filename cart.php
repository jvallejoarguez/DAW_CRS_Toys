<?php
session_start();
include 'header.php';
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['remove'])) {
        // Eliminar producto del carrito
        $product_id = $_POST['product_id'];
        $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        // Actualizar cantidad del producto
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Obtener productos del carrito
$sql = "SELECT p.id, p.name, p.description, p.price, p.image, c.quantity FROM products p JOIN cart c ON p.id = c.product_id WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
?>
<main>

<h2>Carrito de Compras</h2>

<div class="cart">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="cart-item">
            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <p>Precio: €<?php echo htmlspecialchars($row['price']); ?></p>
            <form action="cart.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                <p>Cantidad: <input type="number" name="quantity" value="<?php echo htmlspecialchars($row['quantity']); ?>" min="1"></p>
                <p>Total: €<?php echo htmlspecialchars($row['price'] * $row['quantity']); ?></p>
                <button type="submit" name="update">Actualizar Cantidad</button>
                <button type="submit" name="remove">Eliminar</button>
            </form>
        </div>
        <?php $total += $row['price'] * $row['quantity']; ?>
    <?php endwhile; ?>
</div>

<h3>Total: €<?php echo $total; ?></h3>
<a href="checkout.php" class="checkout-button">Proceder al Pago</a>
</main>
<?php
$stmt->close();
$conn->close();
include 'footer.php';
?>
