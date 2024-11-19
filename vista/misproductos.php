<?php
session_start();
include 'conexion.php'; // Asegúrate de que la conexión a la base de datos está correcta

// Verificar si el usuario está logueado y es un agricultor
if (!isset($_SESSION['loggedin']) || $_SESSION['userType'] !== 'campesino') {
    header('Location: login.php'); // Redirigir al login si no está logueado
    exit;
}

// Obtener los productos del agricultor desde la base de datos
$sql = "SELECT * FROM producto WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Productos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <h1>Mis Productos</h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="subirproducto.php">Subir Producto</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <div class="productos-container">
        <?php
        // Mostrar los productos del agricultor
        while ($row = $result->fetch_assoc()) {
            echo "<div class='producto'>";
            echo "<h3>" . htmlspecialchars($row['nombre']) . "</h3>";
            echo "<p>Precio: " . htmlspecialchars($row['precio']) . "</p>";
            echo "<p>Descripción: " . htmlspecialchars($row['descripcion']) . "</p>";
            echo "<p>Stock: " . htmlspecialchars($row['stock']) . "</p>";
            echo "<a href='editarproducto.php?id=" . $row['id'] . "'>Editar</a>"; // Enlace para editar el producto
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>