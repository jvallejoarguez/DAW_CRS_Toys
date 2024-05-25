<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Obtener pedidos del usuario
$sql = "SELECT id, total_amount, created_at FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Perfil</h2>
<p>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>.</p>

<h3>Pedidos Realizados</h3>
<div class="orders">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="order-item">
            <h4>Pedido #<?php echo $row['id']; ?></h4>
            <p>Total: €<?php echo $row['total_amount']; ?></p>
            <p>Fecha: <?php echo $row['created_at']; ?></p>
        </div>
    <?php endwhile; ?>
</div>

<?php
$stmt->close();
$conn->close();
include 'footer.php';
?>
