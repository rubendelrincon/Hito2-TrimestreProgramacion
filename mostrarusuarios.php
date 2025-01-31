<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    body {
        background-image: url('cine.jpg'); /* Imagen de fondo */
        background-size: cover; /* Cubre toda la pantalla */
        display: flex; /* Flexbox para centrar contenido */
        justify-content: center; /* Centrado horizontal */
        align-items: center; /* Centrado vertical */
        height: 100vh; /* Altura completa de la ventana */
        margin: 0; /* Sin margen */
        font-family: Arial, sans-serif; /* Fuente */
    }
    .table {
        border-collapse: collapse; /* Colapsar bordes de la tabla */
        width: 80%; /* Ancho de la tabla */
        margin: auto; /* Centrar tabla */
        background-color: white; /* Fondo blanco para la tabla */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
    }
    .table th, .table td {
        border: 1px solid #ddd; /* Bordes de celdas */
        padding: 8px; /* Espaciado interno */
        text-align: center; /* Texto centrado */
    }
    .table th {
        background-color: #f2f2f2; /* Fondo gris claro para encabezados */
    }
    .btn {
        text-decoration: none; /* Sin subrayado en enlaces */
        color: white; /* Color de texto blanco */
        background-color: red; /* Fondo rojo */
        padding: 5px 10px; /* Espaciado interno */
        border-radius: 5px; /* Bordes redondeados */
    }
</style>
</head>
<body>
    <?php
    // Inclusión del archivo de conexión a la base de datos
    include 'conexionbd.php';

    // Consulta para obtener todos los usuarios
    $sql = "SELECT * FROM usuarios";
    $result = $conn->query($sql);

    // Verifica si hay resultados
    if ($result->num_rows > 0) {
        // Comienza la tabla
        echo "<table class='table'>";
        echo "<thead><tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Email</th><th>Edad</th><th>Plan Base</th><th>Duración</th><th>Acciones</th></tr></thead><tbody>";
        
        // Itera sobre cada usuario y crea una fila en la tabla
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["nombre"] . "</td>
                    <td>" . $row["apellido"] . "</td>
                    <td>" . $row["email"] . "</td>
                    <td>" . $row["edad"] . "</td>
                    <td>" . $row["plan_base"] . "</td>
                    <td>" . $row["duracion"] . "</td>
                    <td><a href='eliminar_usuario.php?id=" . $row["id"] . "' class='btn btn-danger'>Eliminar</a></td>
                </tr>";
        }
        echo "</tbody></table>"; // Cierra la tabla
    } else {
        echo "No se encontraron usuarios registrados."; // Mensaje si no hay usuarios
    }

    // Cierra la conexión a la base de datos
    $conn->close();
    ?>
</body>

</html>

