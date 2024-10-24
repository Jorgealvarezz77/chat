<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Redirigir al login si no está autenticado
    exit();
}


include 'conexion.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre'];
    $precio_producto = $_POST['precio'];
    $username = $_SESSION['username']; 
    
    $sql = "INSERT INTO compras (usuario, id_producto, nombre_producto, precio) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisd", $username, $id_producto, $nombre_producto, $precio_producto);

    if ($stmt->execute()) {
        echo "<p>¡Has comprado el producto: $nombre_producto por $$precio_producto!</p>";
        echo "<a href='productos.php'>Volver a productos</a>";
    } else {
        echo "<p>Error al procesar la compra. Inténtalo de nuevo.</p>";
    }

    
    $stmt->close();
    $conn->close();
} else {
    echo "<p>No se ha seleccionado ningún producto.</p>";
}
?>
