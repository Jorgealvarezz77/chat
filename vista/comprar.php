<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Redirigir al login si no está autenticado
    exit();
}

// Incluir la conexión a la base de datos
include 'conexion.php';

// Verificar si se envió un producto para comprar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre'];
    $precio_producto = $_POST['precio'];
    $username = $_SESSION['username']; // El usuario actual logueado

    // Insertar la compra en la tabla de compras o procesarla como desees
    $sql = "INSERT INTO compras (usuario, id_producto, nombre_producto, precio) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisd", $username, $id_producto, $nombre_producto, $precio_producto);

    if ($stmt->execute()) {
        echo "<p>¡Has comprado el producto: $nombre_producto por $$precio_producto!</p>";
        echo "<a href='productos.php'>Volver a productos</a>";
    } else {
        echo "<p>Error al procesar la compra. Inténtalo de nuevo.</p>";
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "<p>No se ha seleccionado ningún producto.</p>";
}
?>
