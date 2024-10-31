<?php
session_start();

// Inicializamos el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Mensaje de carrito vacío
$mensaje = empty($_SESSION['carrito']) ? "El carrito está vacío." : "";

// Función para actualizar cantidad
if (isset($_POST['action'])) {
    $productoId = $_POST['id'];
    foreach ($_SESSION['carrito'] as &$producto) {
        if ($producto['id'] == $productoId) {
            if ($_POST['action'] === 'increment') {
                $producto['cantidad']++;
            } elseif ($_POST['action'] === 'decrement' && $producto['cantidad'] > 1) {
                $producto['cantidad']--;
            } elseif ($_POST['action'] === 'remove') {
                $_SESSION['carrito'] = array_filter($_SESSION['carrito'], function($p) use ($productoId) {
                    return $p['id'] != $productoId;
                });
            }
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras - Agroo app</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="carro.css">
</head>

<body>
    <header>
        <div class="caja">
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="pqr.php">Pqr</a></li>
                    <li><a href="mejores.php">Productos</a></li>
                    <li><a href="carrito.php" class="nav-item active">Carrito(<?php echo count($_SESSION['carrito']); ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <h1>Carrito de Compras</h1>

        <?php if (!empty($mensaje)): ?>
            <p><?php echo $mensaje; ?></p>
        <?php else: ?> 
            
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    
                    foreach ($_SESSION['carrito'] as $producto) {
                        $subtotal = $producto['precio'] * $producto['cantidad'];
                        $total += $subtotal;
                        echo "<tr>";
                        echo "<td>" . $producto['nombre'] . "</td>";
                        echo "<td>$" . number_format($producto['precio'], 2) . "</td>";
                        echo "<td>" . $producto['cantidad'] . "</td>";
                        echo "<td>$" . number_format($subtotal, 2) . "</td>";
                        echo "<td>
                                <form method='post'>
                                    <input type='hidden' name='id' value='{$producto['id']}'>
                                    <button type='submit' name='action' value='increment'>+</button>
                                    <button type='submit' name='action' value='decrement'>-</button>
                                    <button type='submit' name='action' value='remove'>Eliminar</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                    <tr>
                        <td colspan="3"><strong>Total:</strong></td>
                        <td colspan="2"><strong>$<?php echo number_format($total, 2); ?></strong></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <form method="post" action="factura.php">
                <button type="submit" class="btn-procesar">Proceder con la compra</button>
            </form>
        <?php endif; ?>
    </main>

</body>

</html>
