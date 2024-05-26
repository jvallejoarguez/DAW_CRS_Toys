<!-- product_detail.php -->
<?php
session_start();
include 'db.php';

$product_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - CRS Toys</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <header>
        <h1><?php echo $product['name']; ?></h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="categories.php">Categorías</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">Perfil</a></li>
                    <li><a href="cart.php">Carrito</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                    <?php if ($_SESSION['is_admin']): ?>
                        <li><a href="admin.php">Administrador</a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li><a href="register.php">Registro</a></li>
                    <li><a href="login.php">Iniciar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <div class="product-detail">
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            <h2><?php echo $product['name']; ?></h2>
            <p><?php echo $product['description']; ?></p>
            <p>Precio: €<?php echo $product['price']; ?></p>
            <button>Añadir al Carrito</button>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 CRS Toys. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
