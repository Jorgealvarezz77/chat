<?php
session_start(); // Iniciar sesión, esto debe ir al inicio del archivo

// Incluir el archivo de conexión
include 'conexion.php'; // Asegúrate de que la ruta a 'conexion.php' sea correcta

// Verificar si los datos fueron enviados por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $stock = $_POST['stock']; // Recoger el stock del producto

    $user_id = $_SESSION['user_id']; // Asegurarse de que user_id esté en la sesión

    // Obtener el nombre del usuario desde la base de datos
    $sql_user = "SELECT username FROM usuario WHERE id = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    $row_user = $result_user->fetch_assoc();
    $username = $row_user['username'];
    
    // Preparar la consulta SQL para insertar el producto incluyendo stock
    $sql = "INSERT INTO producto (nombre, precio, descripcion, imagen, stock, id_usuario) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincular parámetros (bind parameters): "sdssii" significa que son 3 strings, un número (precio), un int (stock) y un int (id_usuario)
        $stmt->bind_param("sdssii", $name, $price, $description, $image, $stock, $user_id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Producto subido exitosamente.";

            // Mostrar el nombre del usuario justo después de la subida del producto
            echo "<br>Subido por: " . htmlspecialchars($username); // Mostrar el nombre del usuario
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <title>Productos - Agroo app</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        .contenedor {
            text-align: center;
        }
    </style>
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
                <?php else: ?>
                    <li><a href="login.php">Iniciar sesión</a></li>
                    <li><a href="registro.php">Registrarse</a></li>
                <?php endif; ?>
                <li class="nav-item active">
                    <a class="nav-link" href="carrito.php"><i class="fa-solid fa-cart-shopping"></i> (<?php echo count($_SESSION['carrito']); ?>)</a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="form-container">
        <h1>Subir Producto</h1>
        <form action="subirproducto.php" method="POST">
            <label for="name">Nombre del Producto:</label>
            <input type="text" id="name" name="name" required>

            <label for="price">Precio:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="description">Descripción:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="stock">Stock:</label> <!-- Nuevo campo de stock -->
            <input type="number" id="stock" name="stock" required>

            <label for="image">Seleccionar Imagen:</label>
            <select id="image" name="image" onchange="updatePreview()" required>
                <option value="papa.jpeg" data-img="../imagenes/papa.jpeg">Bulto papa</option>
                <option value="bultocafe.jpg" data-img="../imagenes/bultocafe.jpg">Bulto café</option>
                <option value="bultomaiz.jpg" data-img="../imagenes/bultomaiz.jpg">Bulto maíz</option>
            </select><br>

            <!-- Imagen previsualizada -->
            <img id="preview" src="../imagenes/papa.jpeg" alt="Previsualización de la imagen seleccionada">

            <input type="submit" value="Subir Producto">
        </form>
    </div>

    <script>
        // Función para actualizar la previsualización de la imagen
        function updatePreview() {
            // Obtener el elemento <select> y la opción seleccionada
            var select = document.getElementById("image");
            var selectedOption = select.options[select.selectedIndex];

            // Obtener el atributo 'data-img' de la opción seleccionada
            var imageSrc = selectedOption.getAttribute("data-img");

            // Actualizar el src de la imagen de previsualización
            document.getElementById("preview").src = imageSrc;
        }

        // Inicializar la previsualización con la primera opción seleccionada
        window.onload = function() {
            updatePreview();
        };
    </script>

</body>
</html>