<?php
session_start();

// Simulación de los productos en el carrito
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
    // Contenido HTML de la factura
    $factura_html = "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }
            .container {
                width: 80%;
                margin: 0 auto;
                background-color: white;
                padding: 20px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            h1 {
                text-align: center;
                color: #4CAF50;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            th, td {
                padding: 10px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            th {
                background-color: #4CAF50;
                color: white;
            }
            .total {
                font-size: 18px;
                font-weight: bold;
                text-align: right;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Factura de Compra</h1>
            <table>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>";
    
    foreach ($carrito as $producto) {
        $factura_html .= "
        <tr>
            <td>" . $producto['nombre'] . "</td>
            <td>" . $producto['cantidad'] . "</td>
            <td>$" . number_format($producto['precio'], 2) . "</td>
            <td>$" . number_format($producto['precio'] * $producto['cantidad'], 2) . "</td>
        </tr>";
    }

    $factura_html .= "
            </table>
            <div class='total'>
                Total a pagar: $" . number_format($total_carrito, 2) . "
            </div>
        </div>
    </body>
    </html>";

    // Crear la carpeta si no existe
    $folder = 'factura/';
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }
    
    // Nombre del archivo de la factura
    $nombre_factura = "factura_" . date("Ymd_His") . ".html";
    
    // Guardar la factura HTML dentro de la carpeta 'factura'
    file_put_contents($folder . $nombre_factura, $factura_html);
    
    // Forzar la descarga del archivo HTML
    header('Content-Type: text/html');
    header('Content-Disposition: attachment; filename="' . $nombre_factura . '"');
    readfile($folder . $nombre_factura);
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago con Nequi</title>
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
