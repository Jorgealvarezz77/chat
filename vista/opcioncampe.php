<?php
session_start();
include 'conexion.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <nav>
        <h1 class="titulo-principal">AGROO APP</h1>
        <ul>
    <li><a href="index.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">Home</a></li>
    <li><a href="pqr.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'pqr.php') ? 'active' : ''; ?>">PQR</a></li>
    <li><a href="mejores.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'mejores.php') ? 'active' : ''; ?>">Productos</a></li>
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <li><a href="logout.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'logout.php') ? 'active' : ''; ?>">Cerrar sesión</a></li>
        <li><a href="subirproducto.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'subirproducto.php') ? 'active' : ''; ?>">Subir producto</a></li>
    <?php else: ?>
        <li><a href="login.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'login.php') ? 'active' : ''; ?>">Iniciar sesión</a></li>
        <li><a href="registro.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'registro.php') ? 'active' : ''; ?>">Registrarse</a></li>
    <?php endif; ?>
    <li><a href="carrito.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'carrito.php') ? 'active' : ''; ?>"><i class="fa-solid fa-cart-shopping"></i> (<?php echo isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?>)</a></li>
</ul>
    </nav>
</header>

    <main class="container mt-4">
        <h2>escoge una opcion</h2>
        <button onclick="location.href='mejores.php'">Inicio</button>
        <button onclick="location.href='subirproducto.php'">Subir Producto</button>
       
    </main>    
</body>
</html>
