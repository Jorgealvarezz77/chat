<?php
session_start(); // Esto debe ir al inicio del archivo
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos - Agroo app</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <header>
        <div class="caja">
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="pqr.php">Pqr</a></li>
                    <li><a href="mejores.php">Productos</a></li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <li><a href="logout.php">Cerrar sesión</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Iniciar sesión</a></li>
                        <li><a href="registro.php">Registrarse</a></li>

                    <?php endif; ?>
                    <li class="nav-item active">
                    <li class="nav-item active"><a class="nav-link" href="carrito.php"><i class="fa-solid fa-cart-shopping"></i>(<?php echo count($_SESSION['carrito']); ?>)</a></li>
                </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="form-container">
            <h2>Contacta con Nosotros</h2>
            <form>
                <label for="nombre_apellido">Nombre y Apellido</label>
                <input type="text" id="nombre_apellido" name="nombre_apellido" required>

                <label for="correo_electronico">Correo Electrónico</label>
                <input type="email" id="correo_electronico" name="correo_electronico" required placeholder="ejemplo@gmail.com">

                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" required placeholder="(311) 123 4567">

                <label for="queja">Queja</label>
                <textarea id="queja" name="queja" cols="70" rows="10" required></textarea>

                <input type="submit" value="Enviar Queja" class="enviar">
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Agroo App. Todos los derechos reservados.</p>
    </footer>
</body>

</html>
