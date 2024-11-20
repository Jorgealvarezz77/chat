<?php
session_start();

// Lista de productos disponibles
$productos = [
    1 => ["nombre" => "Producto 1", "precio" => 10.00],
    2 => ["nombre" => "Producto 2", "precio" => 15.00],
    3 => ["nombre" => "Producto 3", "precio" => 20.00]
];

// Inicializar el carrito en la sesión si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Manejar acciones de agregar, eliminar, aumentar y disminuir la cantidad
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_POST['id_producto'];
    $accion = $_POST['accion'];

    if ($accion === 'agregar' && isset($productos[$id_producto])) {
        // Agregar producto al carrito
        if (isset($_SESSION['carrito'][$id_producto])) {
            $_SESSION['carrito'][$id_producto]['cantidad']++;
        } else {
            $_SESSION['carrito'][$id_producto] = [
                "nombre" => $productos[$id_producto]["nombre"],
                "precio" => $productos[$id_producto]["precio"],
                "cantidad" => 1
            ];
        }
    } elseif ($accion === 'eliminar' && isset($_SESSION['carrito'][$id_producto])) {
        // Eliminar producto del carrito
        unset($_SESSION['carrito'][$id_producto]);
    } elseif ($accion === 'aumentar' && isset($_SESSION['carrito'][$id_producto])) {
        // Aumentar la cantidad del producto
        $_SESSION['carrito'][$id_producto]['cantidad']++;
    } elseif ($accion === 'disminuir' && isset($_SESSION['carrito'][$id_producto])) {
        // Disminuir la cantidad del producto, eliminándolo si llega a 0
        if ($_SESSION['carrito'][$id_producto]['cantidad'] > 1) {
            $_SESSION['carrito'][$id_producto]['cantidad']--;
        } else {
            unset($_SESSION['carrito'][$id_producto]);
        }
    }
}

// Obtener el carrito actual
$carrito = $_SESSION['carrito'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="carro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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

<h1>Carrito de Compras</h1>
<?php if (empty($carrito)) : ?>
    <p>Tu carrito está vacío.</p>
<?php else : ?>
    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
            <th>Acción</th>
        </tr>
        <?php
        $total_carrito = 0;
        foreach ($carrito as $id => $producto) :
            $total = $producto['precio'] * $producto['cantidad'];
            $total_carrito += $total;
        ?>
            <tr>
                <td><?php echo $producto['nombre']; ?></td>
                <td>
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="id_producto" value="<?php echo $id; ?>">
                        <input type="hidden" name="accion" value="disminuir">
                        <button type="submit">-</button>
                    </form>
                    <?php echo $producto['cantidad']; ?>
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="id_producto" value="<?php echo $id; ?>">
                        <input type="hidden" name="accion" value="aumentar">
                        <button type="submit">+</button>
                    </form>
                </td>
                <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                <td>$<?php echo number_format($total, 2); ?></td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="id_producto" value="<?php echo $id; ?>">
                        <input type="hidden" name="accion" value="eliminar">
                        <button type="submit" class="boton-eliminar">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3">Total</td>
            <td colspan="2">$<?php echo number_format($total_carrito, 2); ?></td>
        </tr>
    </table>

    <!-- Botón para pagar con Nequi -->
    <form action="pago.php" method="POST">
        <input type="hidden" name="total_carrito" value="<?php echo $total_carrito; ?>">
        <button type="submit">Pagar con Nequi</button>
    </form>

<?php endif; ?>

<br>
<footer>
    <p>&copy; 2024 Agroo App. Todos los derechos reservados.</p>
</footer>
</body>
</html>
