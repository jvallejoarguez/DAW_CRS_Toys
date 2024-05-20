<?php
include 'header.php';
?>

<div class="form-container">
    <form action="register_action.php" method="POST">
        <h2>Registrarse</h2>
        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Registrarse</button>
    </form>
</div>

<?php
include 'footer.php';
?>
