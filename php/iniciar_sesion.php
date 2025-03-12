<?php
// Almacenando datos
$usuario = strtolower(limpiar_cadena($_POST['login_usuario'])); // Convertir la entrada del usuario a minúsculas antes de la validación
$clave = limpiar_cadena($_POST['login_clave']);

// Verificando campos obligatorios
if ($usuario == "" || $clave == "") {
    echo '<div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

// Verificando integridad de los datos
if (verificar_datos("^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$|^[a-zA-Z0-9._-]{4,50}$", $usuario)) {
    echo '<div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El USUARIO o CORREO no coincide con el formato solicitado
    </div>';
    exit(); 
}

if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave)) {
    echo '<div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        La CLAVE no coincide con el formato solicitado
    </div>';
    exit(); 
}

// Consulta a la BD
$check_user = conexion();
$check_user = $check_user->query("SELECT * FROM usuarios WHERE (usuario_usuario='$usuario' OR usuario_email='$usuario') AND estado=1");

// Verificar si se seleccionó algún registro en la BD
if ($check_user->rowCount() == 1) {
    $check_user = $check_user->fetch(); // fetch permite hacer un array de datos de la BD mediante la consulta realizada
    // Verificar si la contraseña es correcta
    if (password_verify($clave, $check_user['usuario_clave'])) {
        // Paso 2: Obtener los datos del empleado
        $empleado_id = $check_user['empleado_id'];
        $check_employee = conexion();
        $check_employee = $check_employee->query("SELECT empleado_nombre, empleado_apellido, empleado_genero FROM empleados WHERE empleado_nroLegajo = $empleado_id");
        $employee = $check_employee->fetch();
        
        // Guardar los datos en la sesión
        $_SESSION['id'] = $check_user['usuario_id'];
        $_SESSION['nombre'] = $employee['empleado_nombre'];
        $_SESSION['apellido'] = $employee['empleado_apellido'];
        $_SESSION['genero'] = $employee['empleado_genero'];
        $_SESSION['usuario'] = $check_user['usuario_usuario'];
        $_SESSION['rol'] = $check_user['rol_id']; // Almacena el rol del usuario en la sesión

        // Redirección al home
        if (headers_sent()) {
            echo "<script> window.location.href='index.php?vista=home'; </script>";
        } else {
            header("Location: index.php?vista=home");
        }
    } else {
        echo '<div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Clave incorrecta.
        </div>';
    }
} else {
    echo '<div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        Usuario inactivo o clave incorrecta.
    </div>';
}

$check_user = null;
?>






