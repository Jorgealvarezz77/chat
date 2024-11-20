<?php
include 'conexion.php';
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $email = $_POST['email'];

    
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario (nombre, apellido, username, password, email)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $nombre, $apellido, $username, $password_hashed, $email);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Nuevo registro creado exitosamente</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
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
    <title>Registro de Usuario</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    
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
    <br>
    <div class="form-container">
        <form method="post" action="">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Usuario</button>
        </form>
    </div>
    <br>
    <footer>
        <p>&copy; 2024 Agroo App. Todos los derechos reservados.</p>
    </footer>
    
    <!-- Incluyendo JavaScript de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>