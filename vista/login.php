<?php
session_start();
include 'conexion.php'; // Asegúrate de que este archivo exista y contenga la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType']; // Campo del tipo de usuario seleccionado en el formulario

    // Consultar la base de datos para verificar el usuario
    $sql = "SELECT * FROM usuario WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Crear variables de sesión
            $_SESSION['user_id'] = $user['id']; // Almacenar el ID del usuario en la sesión
            $_SESSION['username'] = $user['username']; // Almacenar el nombre de usuario
            $_SESSION['loggedin'] = true;

            // Redirigir basado en la selección del formulario
            if ($userType == 'campesino') {
                // Redirigir a subirproducto.php si el tipo de usuario es campesino
                header('Location: subirproducto.php');
                exit(); // Asegúrate de finalizar la ejecución después de la redirección
            } else {
                // Redirigir a productos.html si el tipo de usuario es comprador
                header('Location: mejores.php');
                exit(); // Finalizar la ejecución
            }
        } else {
            $error_message = "Contraseña incorrecta.";
        }
    } else {
        $error_message = "Usuario no encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Incluyendo Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }
        
        .form-container {
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Iniciar Sesión</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo de Usuario</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="userType" id="campesino" value="campesino" checked>
                    <label class="form-check-label" for="campesino">
                        Campesino
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="userType" id="comprador" value="comprador">
                    <label class="form-check-label" for="comprador">
                        Comprador
                    </label>
                </div>
            </div>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
    </div>

    <!-- Incluyendo JavaScript de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>