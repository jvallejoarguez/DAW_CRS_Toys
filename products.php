<?php
include 'header.php';
include 'db.php';

// Verificar si se ha proporcionado el ID del producto
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Obtener la información del producto
    $sql = "SELECT name, description, price, image FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($product_name, $product_description, $product_price, $product_image);
    $stmt->fetch();
    $stmt->close();

    // Verificar si se ha encontrado el producto
    if (!$product_name) {
        echo "<p>No se encontró el producto especificado.</p>";
    } else {
        ?>

        <div class="product-details">
            <img src="<?php echo htmlspecialchars($product_image); ?>" alt="<?php echo htmlspecialchars($product_name); ?>">
            <h2><?php echo htmlspecialchars($product_name); ?></h2>
            <p><?php echo htmlspecialchars($product_description); ?></p>
            <p>Precio: €<?php echo htmlspecialchars($product_price); ?></p>
            <a href="add_to_cart.php?id=<?php echo $product_id; ?>" class="add-to-cart-button">Añadir al Carrito</a>
        </div>

        <?php
    }
} else {
    echo "<p>Producto no especificado.</p>";
}

$conn->close();
include 'footer.php';
?>
