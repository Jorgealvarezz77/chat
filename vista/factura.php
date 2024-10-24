<?php
session_start(); 


if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "El carrito está vacío. No se puede generar una factura.";
    exit();
}


$carrito = $_SESSION['carrito'];


$numero_factura = 'FAC-' . strtoupper(uniqid());

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - Agroo App</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="factura.css">
</head>

<body>
    <header>
        <h1>Factura de Compra - Agroo App</h1>
        <p><strong>Número de Factura:</strong> <?php echo $numero_factura; ?></p>
        <p><strong>Fecha:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
    </header>

    <main>
        <table class="tabla-factura">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                foreach ($carrito as $producto) {
                    $subtotal = $producto['precio'] * $producto['cantidad'];
                    $total += $subtotal;
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($producto['nombre']) . "</td>";
                    echo "<td>$" . number_format($producto['precio'], 2) . "</td>";
                    echo "<td>" . htmlspecialchars($producto['cantidad']) . "</td>";
                    echo "<td>$" . number_format($subtotal, 2) . "</td>";
                    echo "</tr>";
                }
                ?>
                <tr>
                    <td colspan="3"><strong>Total:</strong></td>
                    <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                </tr>
            </tbody>
        </table>

        <div class="acciones-factura">
            <button onclick="window.print()" class="btn-imprimir">Imprimir Factura</button>
            <a href="index.php" class="btn-volver">Volver a la página principal</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Agroo App. Todos los derechos reservados.</p>
    </footer>
</body>

</html>
