<?php
include 'header.php';
?>

<div class="form-container">
    <form action="login_action.php" method="POST">
        <h2>Iniciar Sesión</h2>
        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
</div>

<?php
include 'footer.php';
?>
