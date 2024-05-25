<?php
include 'header.php';
include 'db.php';

// Obtener las categorías para el formulario de selección
$sql = "SELECT id, name FROM categories";
$result = $conn->query($sql);
?>

<h2>Administrar</h2>

<div class="admin-section">
    <h3>Añadir Producto</h3>
    <form action="admin.php" method="post" enctype="multipart/form-data">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="description">Descripción:</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="price">Precio:</label>
        <input type="number" step="0.01" id="price" name="price" required><br>

        <label for="category">Categoría:</label>
        <select id="category" name="category_id" required>
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="image">Imagen:</label>
        <input type="file" id="image" name="image" required><br>

        <input type="submit" value="Añadir Producto">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];

        // Manejo de la imagen subida
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file;

            // Insertar el producto en la base de datos
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, category_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdsi", $name, $description, $price, $image, $category_id);

            if ($stmt->execute()) {
                echo "Producto añadido exitosamente.";
            } else {
                echo "Error al añadir el producto: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error al subir la imagen.";
        }
    }
    ?>

    <h3>Usuarios y Pedidos</h3>
    <?php
    // Obtener usuarios y sus pedidos
    $sql = "
    SELECT 
        users.id as user_id, 
        users.username, 
        orders.id as order_id, 
        orders.total_amount, 
        orders.created_at, 
        user_orders.name, 
        user_orders.address, 
        user_orders.card, 
        user_orders.expiry, 
        user_orders.cvv 
    FROM 
        users 
    JOIN 
        orders 
    ON 
        users.id = orders.user_id 
    JOIN 
        user_orders 
    ON 
        orders.id = user_orders.order_id 
    ORDER BY 
        orders.created_at DESC";
    $result = $conn->query($sql);
    ?>

    <div class="admin-orders">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="order-item">
                <h4>Usuario: <?php echo htmlspecialchars($row['username']); ?></h4>
                <p>Nombre: <?php echo htmlspecialchars($row['name']); ?></p>
                <p>Dirección: <?php echo htmlspecialchars($row['address']); ?></p>
                <p>Número de Tarjeta: <?php echo htmlspecialchars($row['card']); ?></p>
                <p>Expiración: <?php echo htmlspecialchars($row['expiry']); ?></p>
                <p>CVV: <?php echo htmlspecialchars($row['cvv']); ?></p>
                <p>Pedido #<?php echo $row['order_id']; ?></p>
                <p>Total: €<?php echo $row['total_amount']; ?></p>
                <p>Fecha: <?php echo $row['created_at']; ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php
$conn->close();
include 'footer.php';
?>
