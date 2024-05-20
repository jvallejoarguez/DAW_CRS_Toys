<?php
session_start();
include 'header.php';
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Obtener total del pedido
$sql = "SELECT total_amount FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($total_amount);
$stmt->fetch();
$stmt->close();
?>

<h2>Pago</h2>
<p>El total a pagar es: €<?php echo $total_amount; ?></p>
<p>Esta es una página de pago ficticia. Presiona el botón para completar la compra.</p>

<form action="checkout.php" method="post">
    <button type="submit">Completar Pago</button>
</form>

<?php
include 'footer.php';
?>
