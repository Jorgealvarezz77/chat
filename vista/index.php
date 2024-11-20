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
            $_SESSION['userType'] = $userType; // Asignar el tipo de usuario (campesino o comprador)

            if ($userType == 'campesino') {
                header('Location: opcioncampe.php');
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
    <title>Agroo App</title>
    <link rel="stylesheet" href="style-home.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                <li><a href="logout.php">Cerrar sesión</a></li>
                <li><a href="subirproducto.php">Subir producto</a></li>
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


    <!-- Main Content -->
    <main>

        <img id="logo" src="/imagenes/logoo.png" width="200px"> 

        <!-- Información sobre Agroapp -->
        <section class="diferenciales">
            <h2 class="titulo-centralizado">Sobre Agroapp</h2>
            <p>Ubicada en el corazón de la ciudad, la <strong>Agroo App</strong> trae los mejores productos de los campesinos.</p>
            <p id="mision"><em>Nuestra misión es: <strong>"comprar a los campesinos sin necesidad de intermediarios"</strong>.</em></p>
            <p>Ofrecemos múltiples formas de entrega y compra directa.</p>
        </section>

        <!-- ¿Qué hacemos? -->
        <section>
            <h3 class="titulo-centralizado">¿Qué hacemos?</h3>
            <ul class="mucho">
                <li>Contacto directo con los campesinos</li>
                <li>Mejorar el servicio</li>
                <li>Más información</li>
                <li>Gracias por confiar en nosotros</li>
            </ul>
        </section>

        <br><br><br>
        <!-- Mapa de ubicación -->
        <section class="mapa-contenido">
            <h3 class="titulo-principal">Nuestra Ubicación</h3>
            <p>Nuestro establecimiento está ubicado en el corazón de la ciudad</p>
            <br><br>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8467.812137724452!2d-73.43082151164666!3d5.60995008232904!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e6a78fbd509cd9d%3A0x1ab18010c638a7fc!2sPlanta%20L%C3%A1cteos%20Campesino!5e0!3m2!1ses!2sco!4v1710956820810!5m2!1ses!2sco"
                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Agroo App. Todos los derechos reservados.</p>
    </footer>
</body>

</html>
