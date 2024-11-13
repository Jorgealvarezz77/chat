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
    <link rel="stylesheet" href="login.css">   
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
                    <li class="nav-item active"><a class="nav-link" href="carrito.php"><i class="fa-solid fa-cart-shopping"></i>(<?php echo count($_SESSION['carrito'] ?? []); ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container mt-4">
        <h2>escoge una opcion</h2>
        <button onclick="location.href='mejores.php'">Inicio</button>
        <button onclick="location.href='subirptoducto.php'">Subir Producto</button>
        <button onclick="location.href='catalogo'">Catálogo</button>

    </main>
    
</body>
</html>
