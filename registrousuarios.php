<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 
</head>
<body>
<?php
// Inclusión del archivo de conexión a la base de datos
include 'C:\xampp\htdocs\programacion\HitoProgramacion\conexionbd.php';

// Verifica si el método de la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $edad = $_POST['edad'];
    $plan_base = $_POST['plan_base'];
    $duracion = $_POST['duracion'];
    // Verifica si se han seleccionado paquetes adicionales
    $paquetes = isset($_POST['paquete']) ? $_POST['paquete'] : [];

    // Inserta el usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, email, edad, plan_base, duracion) VALUES (?, ?, ?, ?, ?, ?)");
    // Vincula los parámetros a la sentencia
    $stmt->bind_param("sssiss", $nombre, $apellido, $email, $edad, $plan_base, $duracion);
    
    // Ejecuta la consulta
    if ($stmt->execute()) {
        // Obtiene el ID del usuario insertado
        $id_usuario = $stmt->insert_id;
        $stmt->close();
        
        // Inserta los paquetes adicionales seleccionados
        foreach ($paquetes as $paquete) {
            $stmt = $conn->prepare("INSERT INTO paquetes_usuarios (usuario_id, paquete) VALUES (?, ?)");
            // Vincula los parámetros a la sentencia
            $stmt->bind_param("is", $id_usuario, $paquete);
            $stmt->execute();
            $stmt->close();
        }
        
        // Mensaje de éxito
        echo "Usuario registrado correctamente.";
    } else {
        // Mensaje de error en caso de fallo
        echo "Error en el registro: " . $conn->error;
    }
    
    // Cierra la conexión a la base de datos
    $conn->close();
}
?>
</body>

<script src="validaciones.js" defer></script>"
</html>
