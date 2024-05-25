<?php
include 'header.php';
?>

<h2>Iniciar Sesión</h2>

<?php
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error == 'empty_fields') {
        echo "<script>alert('Por favor, rellena todos los campos.');</script>";
    } elseif ($error == 'wrong_password') {
        echo "<script>alert('Contraseña incorrecta.');</script>";
    } elseif ($error == 'user_not_found') {
        echo "<script>alert('Usuario no encontrado.');</script>";
    } elseif ($error == 'invalid_method') {
        echo "<script>alert('Método de solicitud no permitido.');</script>";
    }
} elseif (isset($_GET['login']) && $_GET['login'] == 'success') {
    echo "<script>alert('Inicio de sesión exitoso. Bienvenido!');</script>";
}
?>

<form action="login_action.php" method="post">
    <label for="username">Nombre de Usuario:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required><br>

    <input type="submit" value="Iniciar Sesión">
</form>

<?php
include 'footer.php';
?>
