<?php
// Iniciar sesión y cargar dependencias
require_once "./inc/session_start.php"; // Iniciar la sesión
require_once "./php/main.php"; // Cargar funciones necesarias

// Verificar si el rol del usuario es administrador (rol 1)
// Si no es administrador, redirigir al index
if ($_SESSION['rol'] != 1) {
    header("Location: index.php"); // Redirigir si no es administrador
    exit(); // Terminar ejecución del script
}

// Verificar si se recibió el 'user_id_del' y 'estado' desde la URL
// 'user_id_del' es el ID del usuario y 'estado' es el nuevo estado (activo o desactivado)
if (isset($_GET['user_id_del']) && isset($_GET['estado'])) {
    $user_id = $_GET['user_id_del']; // Obtener el ID del usuario
    $nuevo_estado = $_GET['estado']; // Obtener el nuevo estado (activo/desactivado)

    // Establecer conexión a la base de datos
    $conexion = conexion();

    // Verificar si el usuario tiene expedientes registrados
    $check_expedientes = $conexion->query("SELECT expediente_responsable FROM expedientes WHERE expediente_responsable = '$user_id' LIMIT 1");

    if ($check_expedientes->rowCount() > 0) {
        // Si el usuario tiene expedientes, no permitir desactivación
        echo '<div class="notification is-danger is-light">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        No podemos desactivar el usuario ya que tiene expedientes registrados.
        </div>';
    } else {
        // Obtener el nombre del usuario desde la base de datos
        $query = $conexion->prepare("SELECT usuario_usuario FROM usuarios WHERE usuario_id = :user_id");
        $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();
        $usuario = $query->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe
        if ($usuario) {
            $nombre_usuario = $usuario['usuario_usuario']; // Obtener el nombre del usuario

            // Preparar la consulta SQL para actualizar el estado del usuario
            $stmt = $conexion->prepare("UPDATE usuarios SET estado = :estado WHERE usuario_id = :user_id_del");
            $stmt->bindValue(':estado', $nuevo_estado, PDO::PARAM_INT); // Asignar el nuevo estado
            $stmt->bindValue(':user_id_del', $user_id, PDO::PARAM_INT); // Asignar el ID del usuario

            // Ejecutar la consulta y verificar si se actualizó correctamente
            if ($stmt->execute()) {
                // Verificar si el estado es 1 (activo) o 0 (inactivo) y mostrar el mensaje correspondiente
                if ($nuevo_estado == 1) {
                    // Si el usuario fue activado
                    echo '<div class="alert alert-success" role="alert">
                    <strong>¡Usuario activado!</strong><br>
                    El usuario "' . $nombre_usuario . '" ha sido marcado como activo.
                    </div>';
                } else {
                    // Si el usuario fue desactivado
                    echo '<div class="alert alert-info" role="alert">
                    <strong>¡Usuario desactivado!</strong><br>
                    El usuario "' . $nombre_usuario . '" ha sido marcado como inactivo.
                    </div>';
                }
            } else {
                // Mostrar mensaje de error si ocurre algún problema
                echo '<div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo actualizar el estado del usuario, por favor intente nuevamente.
                </div>';
            }
        } else {
            // Si no se encuentra el usuario en la base de datos
            echo '<div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El usuario que intentas desactivar no existe.
            </div>';
        }
    }
} else {
    // Si no se recibe el usuario_id_del o estado
    echo '<div class="notification is-danger is-light">
    <strong>¡Ocurrió un error inesperado!</strong><br>
    El usuario que intentas desactivar no existe.
    </div>';
}
?>
