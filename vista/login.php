<?php
session_start();
include 'conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType']; 

    
    $sql = "SELECT * FROM usuario WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        
        if (password_verify($password, $user['password'])) {
            
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['username'] = $user['username']; 
            $_SESSION['loggedin'] = true;

           
            if ($userType == 'campesino') {
                
                header('Location: subirproducto.php');
                exit(); 
            } else {
                
                header('Location: mejores.php');
                exit(); 
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
                    <li class="nav-item active"><a class="nav-link" href="carrito.php"><i class="fa-solid fa-cart-shopping"></i>(<?php echo count($_SESSION['carrito']); ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

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