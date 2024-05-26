<?php
include 'header.php';
?>

<h2>Registrarse</h2>

<?php
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error == 'empty_fields') {
        echo "<script>alert('Por favor, rellena todos los campos.');</script>";
    } elseif ($error == 'user_exists') {
        echo "<script>alert('El nombre de usuario ya está en uso.');</script>";
    } elseif ($error == 'register_failed') {
        echo "<script>alert('Error en el registro. Por favor, inténtalo de nuevo.');</script>";
    } elseif ($error == 'invalid_method') {
        echo "<script>alert('Método de solicitud no permitido.');</script>";
    }
} elseif (isset($_GET['register']) && $_GET['register'] == 'success') {
    echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.');</script>";
}
?>

<form action="register_action.php" method="post">
    <label for="username">Nombre de Usuario:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required><br>

    <input type="submit" value="Registrarse">
</form>

<?php
include 'footer.php';
?>
