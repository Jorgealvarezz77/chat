<?php
session_start(); // Esto debe ir al inicio del archivo

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Función para agregar productos al carrito
if (isset($_POST['agregar_carrito'])) {
    $producto = [
        'nombre' => $_POST['nombre'],
        'precio' => $_POST['precio'],
        'stock' => $_POST['stock'],
        'cantidad' => 1
    ];

    // Verificar si el producto ya está en el carrito
    $encontrado = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['nombre'] == $producto['nombre']) {
            // Si el producto ya está en el carrito, verificar el stock disponible
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
        // Agregar el nuevo producto al carrito si hay stock disponible
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
                    <li class="nav-item active"><a class="nav-link" href="carrito.php"><i class="fa-solid fa-cart-shopping"></i>(<?php echo count($_SESSION['carrito']); ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <ul class="productos">
            <div class="container">
                <br>
                <div class="alert alert-success">
                    <!-- Aquí puedes mostrar mensajes de éxito o error -->
                </div>
            </div>

            <?php
            // Incluir el archivo de conexión
            include 'conexion.php';

            // Obtener los productos, incluyendo el stock y el nombre del usuario que los subió
            $sql = "SELECT p.id, p.nombre, p.precio, p.descripcion, p.imagen, p.stock, u.username 
                    FROM producto p 
                    JOIN usuario u ON p.id_usuario = u.id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Mostrar cada producto
                while ($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo "<h2>" . htmlspecialchars($row['nombre']) . "</h2>";
                    echo "<img src='../imagenes/" . htmlspecialchars($row['imagen']) . "' width='300px'>";
                    echo "<p class='producto-descripcion'>" . htmlspecialchars($row['descripcion']) . "</p>";
                    echo "<p class='producto-precio'>Precio: $" . htmlspecialchars($row['precio']) . "</p>";
                    echo "<p class='producto-stock'>Stock disponible: " . htmlspecialchars($row['stock']) . "</p>"; // Mostrar el stock
                    echo "<br>Subido por: " . htmlspecialchars($row['username']); // Mostrar el nombre del usuario que subió el producto

                    // Formulario para agregar al carrito
                    echo "<div class='contenedor'>";
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='nombre' value='" . htmlspecialchars($row['nombre']) . "'>";
                    echo "<input type='hidden' name='precio' value='" . htmlspecialchars($row['precio']) . "'>";
                    echo "<input type='hidden' name='stock' value='" . htmlspecialchars($row['stock']) . "'>"; // Incluir el stock en el formulario
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
        <footer>
        <p>&copy; 2024 Agroo App. Todos los derechos reservados.</p>
    </footer>
    </main>

</body>

</html>