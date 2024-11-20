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
            $_SESSION['loggedin'] = true ;

           
            if ($userType == 'campesino') {
                header('Location: opcioncampe.php');
                exit(); 
            } else  {
                
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
</head>
<body>

<header>
<nav>
        <h1 class="titulo-principal">AGROO APP</h1>
        <ul>
    <li><a href="index.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">Home</a></li>
    <li><a href="pqr.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'pqr.php') ? 'active' : ''; ?>">PQR</a></li>
    <li><a href="mejores.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'mejores.php') ? 'active' : ''; ?>">Productos</a></li>
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <li><a href="logout.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'logout.php') ? 'active' : ''; ?>">Cerrar sesión</a></li>
        <li><a href="subirproducto.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'subirproducto.php') ? 'active' : ''; ?>">Subir producto</a></li>
    <?php else: ?>
        <li><a href="login.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'login.php') ? 'active' : ''; ?>">Iniciar sesión</a></li>
        <li><a href="registro.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'registro.php') ? 'active' : ''; ?>">Registrarse</a></li>
    <?php endif; ?>
    <li><a href="carrito.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'carrito.php') ? 'active' : ''; ?>"><i class="fa-solid fa-cart-shopping"></i> (<?php echo isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?>)</a></li>
</ul>
    </nav>
</header>
<br><br>



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

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    
    <footer>
        <p>&copy; 2024 Agroo App. Todos los derechos reservados.</p>
    </footer>
</body>
</html>