<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $celular = $_POST['celular'];
    $valor = $_POST['valor'];

    // Simulación de validación
    if (empty($celular) || empty($valor)) {
        $mensaje = "Por favor, complete todos los campos.";
    } elseif (!is_numeric($celular) || strlen($celular) != 10) {
        $mensaje = "Ingrese un número de celular válido (10 dígitos).";
    } elseif ($valor <= 0) {
        $mensaje = "El valor debe ser mayor a 0.";
    } else {
        $mensaje = "Pago de $ $valor realizado con éxito desde el número $celular.";
    }
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
        <?php if (isset($mensaje)): ?>
            <div class="mensaje"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>
        <!-- Botón para volver al menú principal -->
        <button type="button" class="btn-back" onclick="window.location.href='index.php';">Volver al menú principal</button>
    </form>
</body>
</html>
