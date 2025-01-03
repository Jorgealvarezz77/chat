<?php
session_start(); 


if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}


if (isset($_POST['agregar_carrito'])) {
    $producto = [
        'nombre' => $_POST['nombre'],
        'precio' => $_POST['precio'],
        'stock' => $_POST['stock'],
        'cantidad' => 1
    ];

   
    $encontrado = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['nombre'] == $producto['nombre']) {
            
            if ($item['cantidad'] < $producto['stock']) {
                $item['cantidad']++;
                $encontrado = true;
            } else {
                echo "<script>alert('No hay suficiente stock disponible.');</script>";
            }
            break;
        }
    }

    if (!$encontrado && $producto['stock'] > 0) {
        
        $_SESSION['carrito'][] = $producto;
    } elseif ($producto['stock'] <= 0) {
        echo "<script>alert('Este producto no tiene stock disponible.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Agroo app</title>
    
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        .contenedor {
            text-align: center;
        }
    </style>
</head>

<body>
<header>
    <nav>
        <h1 class="titulo-principal">AGROO APP</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="pqr.php">PQR</a></li>
            <li><a href="mejores.php">Productos</a></li>
            
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <?php if (isset($_SESSION['userType']) && $_SESSION['userType'] === 'campesino'): ?>
                    <li><a href="subirproducto.php">Subir producto</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Cerrar sesión</a></li>
            <?php else: ?>
                <li><a href="login.php">Iniciar sesión</a></li>
                <li><a href="registro.php">Registrarse</a></li>
            <?php endif; ?>

            <li class="nav-item active">
                <a class="nav-link" href="carrito.php"><i class="fa-solid fa-cart-shopping"></i> (<?php echo isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?>)</a>
            </li>
        </ul>
    </nav>
</header>


    <main>
        <ul class="productos">
            <div class="container">
                <br>
                <div class="alert alert-success">
                   
                </div>
            </div>

            <?php
           
            include 'conexion.php';

            // Obtener los productos, incluyendo el stock y el nombre del usuario que los subió
            $sql = "SELECT p.id, p.nombre, p.precio, p.descripcion, p.imagen, p.stock, u.username 
                    FROM producto p 
                    JOIN usuario u ON p.id_usuario = u.id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // muestra cada producto
                while ($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo "<h2>" . htmlspecialchars($row['nombre']) . "</h2>";
                    echo "<img src='../imagenes/" . htmlspecialchars($row['imagen']) . "' width='300px'>";
                    echo "<br>";
                    echo "<p class='producto-descripcion'>" . htmlspecialchars($row['descripcion']) . "</p>";
                    echo "<br>";
                    echo "<p class='producto-precio'>Precio: $" . htmlspecialchars($row['precio']) . "</p>";
                    echo "<br>";
                    echo "<p class='producto-stock'>Stock disponible: " . htmlspecialchars($row['stock']) . "</p>"; // Mostrar el stock
                    echo "<br>Subido por: " . htmlspecialchars($row['username']); // Mostrar el nombre del usuario que subió el producto

                    // Formulario para agregar al carrito
                    echo "<div class='contenedor'>";
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='nombre' value='" . htmlspecialchars($row['nombre']) . "'>";
                    echo "<input type='hidden' name='precio' value='" . htmlspecialchars($row['precio']) . "'>";
                    echo "<input type='hidden' name='stock' value='" . htmlspecialchars($row['stock']) . "'>"; // Incluir el stock en el formulario
                    echo "<br>";
                    echo "<input type='submit' name='agregar_carrito' value='comprar' class='enviar'>";
                    echo "</form>";
                    echo "</div>";

                    echo "</li><br><br>";
                }
            } else {
                echo "<p>No hay productos disponibles.</p>";
            }

            // Cerrar la conexión
            $conn->close();
            ?>
        </ul>
    </main>

    <footer>
        <p>&copy; 2024 Agroo App. Todos los derechos reservados.</p>
    </footer>

</body>

</html>