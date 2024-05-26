<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Obtener total del pedido más reciente
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
<p>Esta es una página de pago ficticia. Por favor, complete el formulario a continuación para completar su compra.</p>

<form action="complete_order.php" method="post">
    <label for="name">Nombre Completo:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="address">Dirección:</label>
    <input type="text" id="address" name="address" required><br>

    <label for="card">Número de Tarjeta:</label>
    <input type="text" id="card" name="card" required><br>

    <label for="expiry">Fecha de Expiración (MM/AA):</label>
    <input type="text" id="expiry" name="expiry" required><br>

    <label for="cvv">CVV:</label>
    <input type="text" id="cvv" name="cvv" required><br>

    <button type="submit">Completar Pedido</button>
</form>

<?php
include 'footer.php';
?>
