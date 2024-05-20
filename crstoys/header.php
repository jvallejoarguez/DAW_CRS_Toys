<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRS Toys</title>
    <link rel="stylesheet" type="text/css" href="assets/styles.css">
</head>
<body>
    <header>
        <h1>CRS Toys</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="categories.php">Categorías</a>
                    <ul>
                        <?php
                        include 'db.php';
                        $sql = "SELECT id, name FROM categories";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()):
                        ?>
                            <li><a href="categories.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">Perfil</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                    <?php if ($_SESSION['username'] == 'root'): ?>
                        <li><a href="admin.php">Administrar</a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li><a href="login.php">Iniciar Sesión</a></li>
                    <li><a href="register.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
