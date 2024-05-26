<?php
include 'header.php';
include 'db.php';

// Obtener productos destacados
$sql = "SELECT id, name, description, price, image FROM products ORDER BY created_at DESC LIMIT 6";
$result = $conn->query($sql);
?>

<main>
    <div class="welcome">
        <h1>Bienvenido a CRS Toys</h1>
        <p>Tu tienda favorita de figuras de superhéroes, Funko Pop y anime.</p>
    </div>

    <div class="products">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-item">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <p>Precio: €<?php echo htmlspecialchars($row['price']); ?></p>
                <a href="add_to_cart.php?id=<?php echo $row['id']; ?>" class="add-to-cart-button">Añadir al Carrito</a>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php
$conn->close();
include 'footer.php';
?>
