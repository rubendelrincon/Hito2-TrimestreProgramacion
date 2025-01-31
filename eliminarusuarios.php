<?php
include 'conexionbd.php';

if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Eliminar los paquetes relacionados con el usuario
    $stmt = $conn->prepare("DELETE FROM paquetes_usuarios WHERE usuario_id = ?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $stmt->close();

    // Eliminar al usuario de la tabla usuarios
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id_usuario);

    if ($stmt->execute()) {
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID de usuario no proporcionado.";
}
?>
