<?php
include 'header.php';
include 'db.php';

// Verificar si se ha proporcionado el ID de la categoría
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Obtener la información de la categoría
    $sql = "SELECT name, description FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $stmt->bind_result($category_name, $category_description);
    $stmt->fetch();
    $stmt->close();

    // Verificar si se ha encontrado la categoría
    if (!$category_name) {
        echo "<p>No se encontró la categoría especificada.</p>";
    } else {
        // Obtener los productos de la categoría
        $sql = "SELECT id, name, description, price, image FROM products WHERE category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>

        <h2 class="category-title"><?php echo htmlspecialchars($category_name); ?></h2>
        <p class="category-description"><?php echo htmlspecialchars($category_description); ?></p>
        <div class='products'>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class='product-item'>
                    <img src='<?php echo htmlspecialchars($row['image']); ?>' alt='<?php echo htmlspecialchars($row['name']); ?>'>
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <p>Precio: €<?php echo htmlspecialchars($row['price']); ?></p>
                    <a href='add_to_cart.php?id=<?php echo $row['id']; ?>' class="add-to-cart-button">Añadir al Carrito</a>
                </div>
            <?php endwhile; ?>
        </div>

        <?php
        $stmt->close();
    }
} else {
    // Mostrar todas las categorías
    $sql = "SELECT id, name, description FROM categories";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2 class='all-categories-title'>Categorías</h2>";
        echo "<div class='categories'>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='category-item'>";
            echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
            echo "<a href='categories.php?id=" . $row['id'] . "' class='view-products-button'>Ver Productos</a>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>No hay categorías disponibles.</p>";
    }
}

$conn->close();
include 'footer.php';
?>
