<?php
session_start();

// Simulación de los productos en el carrito (esto debe venir de la sesión)
$carrito = [
    1 => ["nombre" => "Producto 1", "precio" => 10.00, "cantidad" => 2],
    2 => ["nombre" => "Producto 2", "precio" => 15.00, "cantidad" => 1],
];

// Obtener el total del carrito
$total_carrito = 0;
foreach ($carrito as $producto) {
    $total_carrito += $producto['precio'] * $producto['cantidad'];
}

// Generar la factura si se hace una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generar_factura'])) {
    // Contenido de la factura
    $factura = "Factura de Compra\n\n";
    foreach ($carrito as $id => $producto) {
        $factura .= "Producto: " . $producto['nombre'] . "\n";
        $factura .= "Cantidad: " . $producto['cantidad'] . "\n";
        $factura .= "Precio: $" . number_format($producto['precio'], 2) . "\n";
        $factura .= "Total: $" . number_format($producto['precio'] * $producto['cantidad'], 2) . "\n\n";
    }
    $factura .= "Total a pagar: $" . number_format($total_carrito, 2) . "\n";
    
    // Crear el archivo de la factura
    $nombre_factura = "factura_" . date("Ymd_His") . ".txt";
    file_put_contents($nombre_factura, $factura);
    
    // Forzar la descarga del archivo
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="' . $nombre_factura . '"');
    readfile($nombre_factura);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulación de Pago con Nequi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #d4f5d0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #8fbf88;
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            width: 400px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
        }
        h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #fff;
        }
        label {
            font-size: 18px;
            display: block;
            margin-bottom: 10px;
            color: #fff;
        }
        input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        .btn {
            background-color: #6b8e23;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn:hover {
            background-color: #556b2f;
            transform: scale(1.1);
        }
        .mensaje {
            margin-top: 20px;
            padding: 15px;
            background-color: #dff0d8;
            color: #3c763d;
            border-radius: 8px;
            font-size: 18px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-back {
            background-color: #f0ad4e;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-back:hover {
            background-color: #ec971f;
            transform: scale(1.1);
        }
        .btn-generate {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-generate:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h1>Pago con Nequi</h1>
        <label for="celular">Número de celular (Nequi):</label>
        <input type="text" id="celular" name="celular" placeholder="Ej: 3001234567">
        <label for="valor">Valor a pagar:</label>
        <input type="number" id="valor" name="valor" placeholder="Ej: 50000">
        <button type="submit" class="btn">Pagar</button>
        
        <!-- Mostrar el carrito y total -->
        <h2>Productos en el carrito:</h2>
        <?php foreach ($carrito as $producto): ?>
            <p><?php echo $producto['nombre']; ?> - Cantidad: <?php echo $producto['cantidad']; ?> - Precio: $<?php echo number_format($producto['precio'], 2); ?></p>
        <?php endforeach; ?>
        <p><strong>Total a pagar: $<?php echo number_format($total_carrito, 2); ?></strong></p>

        <!-- Botón para generar y descargar factura -->
        <button type="submit" name="generar_factura" class="btn-generate">Generar Factura</button>
        
        <!-- Botón para volver al menú principal -->
        <button type="button" class="btn-back" onclick="window.location.href='index.php';">Volver al menú principal</button>
    </form>
</body>
</html>
