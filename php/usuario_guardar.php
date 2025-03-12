<?php
require_once 'main.php'; // Conexión a la base de datos

// Verificar que el formulario fue enviado mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Iniciar una transacción para garantizar la integridad de los datos
        $conexion = conexion();
        $conexion->beginTransaction();

        // Sanitizar y validar datos recibidos del formulario para el empleado
        $nombre = validar_campo($_POST['empleado_nombre'], '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}$/');
        $apellido = validar_campo($_POST['empleado_apellido'], '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}$/');
        $dni = validar_campo($_POST['empleado_dni'], '/^\d{8,10}$/');
        $telefono = validar_campo($_POST['empleado_telefono'], '/^\d{10}$/');
        $area_id = filter_var($_POST['area_id'], FILTER_VALIDATE_INT);

         // Validar el campo de género
         $genero = $_POST['empleado_genero'];
         $generos_validos = ['Femenino', 'Masculino', 'Otro'];
         if (!in_array($genero, $generos_validos)) {
             throw new Exception('El género seleccionado no es válido.');
         }

        // Validar los campos obligatorios del empleado
        if (!$nombre || !$apellido || !$dni || !$telefono || !$area_id || !$genero) {
            throw new Exception('Todos los campos del empleado deben completarse correctamente.');
        }

        // Verificar si el DNI ya existe
        $query_DNI = $conexion->prepare("SELECT empleado_dni FROM empleados WHERE empleado_dni = ? LIMIT 1");
        $query_DNI->execute([$dni]);
        if ($query_DNI->rowCount() > 0) {
            throw new Exception('Ya existe un empleado con ese DNI.');
        }

        // Verificar si el Teléfono ya existe
        $query_Tel = $conexion->prepare("SELECT empleado_telefono FROM empleados WHERE empleado_telefono = ? LIMIT 1");
        $query_Tel->execute([$telefono]);
        if ($query_Tel->rowCount() > 0) {
            throw new Exception('Ya existe un empleado con ese número de teléfono.');
        }

        // Insertar el nuevo empleado en la base de datos
        $query_empleado = $conexion->prepare(
            "INSERT INTO empleados (empleado_nombre, empleado_apellido, empleado_dni, empleado_telefono, empleado_genero, area_id) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        $query_empleado->execute([$nombre, $apellido, $dni, $telefono, $genero, $area_id]);

        // Obtener el ID del empleado recién insertado
        $empleado_id = $conexion->lastInsertId();

        // Validar y procesar los datos del usuario
        $usuario = validar_campo($_POST['usuario_usuario'], '/^[a-zA-Z0-9]{4,20}$/');
        $clave = $_POST['usuario_clave_1'];
        $clave_repetida = $_POST['usuario_clave_repetida'];
        $email = filter_var(trim($_POST['usuario_email']), FILTER_VALIDATE_EMAIL);
        $rol_id = filter_var($_POST['rol_id'], FILTER_VALIDATE_INT);

// Validar contraseñas
if ($clave !== $clave_repetida) {
    throw new Exception('Las contraseñas no coinciden.');
}

// Validar que la clave cumpla con los requisitos de seguridad
$clave_pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$@.-]).{7,100}$/';
if (!preg_match($clave_pattern, $clave)) {
    throw new Exception('La clave debe tener al menos 7 caracteres, incluyendo una mayúscula, un número y un carácter especial ($@.-).');
}


        // Validar campos de usuario
        if (!$usuario || !$clave || !$email || !$rol_id) {
            throw new Exception('Todos los campos de usuario deben completarse correctamente.');
        }

        // Encriptar la contraseña
        $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);

        // Verificar si el usuario ya existe
        $query_usuario = $conexion->prepare("SELECT usuario_usuario FROM usuarios WHERE usuario_usuario = ? LIMIT 1");
        $query_usuario->execute([$usuario]);
        if ($query_usuario->rowCount() > 0) {
            throw new Exception('El usuario ya existe.');
        }

        // Verificar si el Email del usuario ya existe
        $query_email = $conexion->prepare("SELECT usuario_email FROM usuarios WHERE usuario_email = ? LIMIT 1");
        $query_email->execute([$email]);
        if ($query_email->rowCount() > 0) {
            throw new Exception('Ya existe un usuario con ese email.');
        }

        // Insertar el nuevo usuario en la base de datos, vinculando al empleado
        $query_insert_usuario = $conexion->prepare(
            "INSERT INTO usuarios (usuario_usuario, usuario_clave, usuario_email, empleado_id, rol_id) 
             VALUES (?, ?, ?, ?, ?)"
        );

        $query_insert_usuario->execute([$usuario, $clave_encriptada, $email, $empleado_id, $rol_id]);

        // Confirmar la transacción
        $conexion->commit();

        echo '<div class="alert alert-success" role="alert">
        <strong>¡Éxito!</strong><br>
        Empleado y usuario registrados exitosamente.
    </div>';
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollBack();
        echo '<div class="notification is-danger is-light">
        <strong>¡ERROR!</strong><br>' . $e->getMessage() . '</div>';
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
} else {
    // Mostrar error si no es un método POST
    echo '<div class="notification is-danger is-light">
    <strong>¡ERROR!</strong><br>
    Acción no permitida.
</div>';
}

/* // Funciones auxiliares YA SE ENCUENTRA EN EL MAIN.PHP
/**
 * Validar un campo con un patrón dado

function validar_campo($campo, $patron) {
    $campo = trim($campo); // Eliminar espacios al inicio y al final
    return preg_match($patron, $campo) ? $campo : false; // Validar contra el patrón
} */

?>

