<?php
include 'conexionbd.php';

// Verifica si se ha pasado un ID de usuario válido a través de la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario = $_GET['id']; // Asigna el ID del usuario a una variable
    $sql = "SELECT * FROM usuarios WHERE id = ?"; // Prepara la consulta SQL para obtener el usuario
    $stmt = $conn->prepare($sql); // Prepara la declaración SQL
    $stmt->bind_param("i", $id_usuario); // Vincula el parámetro (ID del usuario) a la consulta
    $stmt->execute(); // Ejecuta la consulta
    $result = $stmt->get_result(); // Obtiene el resultado de la consulta
    $usuario = $result->fetch_assoc(); // Extrae los datos del usuario como un array asociativo
} else {
    echo "ID de usuario no válido."; // Mensaje de error si el ID no es válido
    exit; // Termina la ejecución del script
}

// Verifica si la solicitud es de tipo POST (envío de formulario)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $nombre = $_POST['nombre']; // Nombre del usuario
    $apellido = $_POST['apellido']; // Apellido del usuario
    $email = $_POST['email']; // Email del usuario
    $edad = $_POST['edad']; // Edad del usuario
    $plan_base = $_POST['plan_base']; // Plan base seleccionado
    $duracion = $_POST['duracion']; // Duración seleccionada
    $paquetes = isset($_POST['paquete']) ? $_POST['paquete'] : []; // Paquetes seleccionados (pueden ser múltiples)

    // Actualizar los datos del usuario en la base de datos
    $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, edad = ?, plan_base = ?, duracion = ? WHERE id = ?");
    // Vincula los parámetros a la consulta
    $stmt->bind_param("sssissi", $nombre, $apellido, $email, $edad, $plan_base, $duracion, $id_usuario);

    // Ejecuta la consulta de actualización
    if ($stmt->execute()) {
        // Si la actualización es exitosa, primero elimina los paquetes existentes del usuario
        $stmt = $conn->prepare("DELETE FROM paquetes_usuarios WHERE usuario_id = ?");
        $stmt->bind_param("i", $id_usuario); // Vincula el ID del usuario
        $stmt->execute(); // Ejecuta la eliminación de paquetes

        // Inserta los nuevos paquetes seleccionados
        foreach ($paquetes as $paquete) {
            $stmt = $conn->prepare("INSERT INTO paquetes_usuarios (usuario_id, paquete) VALUES (?, ?)");
            // Vincula el ID del usuario y el paquete
            $stmt->bind_param("is", $id_usuario, $paquete);
            $stmt->execute(); // Ejecuta la inserción de cada paquete
        }

        echo "Usuario actualizado correctamente."; // Mensaje de éxito
    } else {
        echo "Error al actualizar el usuario: " . $conn->error; // Mensaje de error si la actualización falla
    }

    $stmt->close(); // Cierra la declaración
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> <!-- Establece la codificación de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configura la vista para dispositivos móviles -->
    <title>Editar Usuario - StreamWeb</title> <!-- Título de la página -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Enlace a Bootstrap para estilos -->
</head>
<body>

    <div class="container mt-5"> <!-- Contenedor principal con margen superior -->
        <h1 class="mb-4 text-center">Editar Usuario</h1> <!-- Título centrado -->

        <form id="registroForm" method="post" action=""> <!-- Formulario para editar el usuario -->
            <div class="form-group"> <!-- Grupo de formulario para el nombre -->
                <label for="nombre">Nombre</label> <!-- Etiqueta para el campo nombre -->
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required> <!-- Campo de entrada para el nombre -->
            </div>
            <div class="form-group"> <!-- Grupo de formulario para el apellido -->
                <label for="apellido">Apellido</label> <!-- Etiqueta para el campo apellido -->
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $usuario['apellido']; ?>" required> <!-- Campo de entrada para el apellido -->
            </div>
            <div class="form-group"> <!-- Grupo de formulario para el email -->
                <label for="email">Email</label> <!-- Etiqueta para el campo email -->
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>" required> <!-- Campo de entrada para el email -->
            </div>
            <div class="form-group"> <!-- Grupo de formulario para la edad -->
                <label for="edad">Edad</label> <!-- Etiqueta para el campo edad -->
                <input type="number" class="form-control" id="edad" name="edad" value="<?php echo $usuario['edad']; ?>" required> <!-- Campo de entrada para la edad -->
            </div>
            <div class="form-group"> <!-- Grupo de formulario para el plan base -->
                <label for="plan_base">Plan Base</label> <!-- Etiqueta para el campo plan base -->
                <select class="form-control" id="plan_base" name="plan_base" required> <!-- Selector para el plan base -->
                    <option value="Basico" <?php if($usuario['plan_base'] == "Basico") echo "selected"; ?>>Básico</option> <!-- Opción para el plan básico -->
                    <option value="Estandar" <?php if($usuario['plan_base'] == "Estandar") echo "selected"; ?>>Estándar</option> <!-- Opción para el plan estándar -->
                    <option value="Premium" <?php if($usuario['plan_base'] == "Premium") echo "selected"; ?>>Premium</option> <!-- Opción para el plan premium -->
                </select>
            </div>
            <div class="form-group"> <!-- Grupo de formulario para la duración -->
                <label for="duracion">Duración</label> <!-- Etiqueta para el campo duración -->
                <select class="form-control" id="duracion" name="duracion" required> <!-- Selector para la duración -->
                    <option value="Mensual" <?php if($usuario['duracion'] == "Mensual") echo "selected"; ?>>Mensual</option> <!-- Opción para duración mensual -->
                    <option value="Anual" <?php if($usuario['duracion'] == "Anual") echo "selected"; ?>>Anual</option> <!-- Opción para duración anual -->
                </select>
            </div>

            <div class="mb-3"> <!-- Grupo de formulario para paquetes -->
                <label class="form-label"></label><br> <!-- Etiqueta vacía para el espacio -->
                <div class="form-check"> <!-- Checkbox para el paquete Deporte -->
                    <input class="form-check-input" type="checkbox" name="paquete[]" value="Deporte" id="deporte">
                    <label class="form-check-label" for="deporte">Deporte</label> <!-- Etiqueta para el checkbox Deporte -->
                </div>
                <div class="form-check"> <!-- Checkbox para el paquete Cine -->
                    <input class="form-check-input" type="checkbox" name="paquete[]" value="Cine" id="cine">
                    <label class="form-check-label" for="cine">Cine</label> <!-- Etiqueta para el checkbox Cine -->
                </div>
                <div class="form-check"> <!-- Checkbox para el paquete Infantil -->
                    <input class="form-check-input" type="checkbox" name="paquete[]" value="Infantil" id="infantil">
                    <label class="form-check-label" for="infantil">Infantil</label> <!-- Etiqueta para el checkbox Infantil -->
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button> <!-- Botón para enviar el formulario -->
        </form>
    </div>


    <!-- Incluir el archivo de validación JavaScript -->
    <script src="validaciones.js" defer></script>
    
</body>
</html>
