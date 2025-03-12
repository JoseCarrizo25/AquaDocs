<?php

require_once "../inc/session_start.php";

require_once "main.php";

// Validar ID y permisos
if ($_SESSION['rol'] != 1 && $_SESSION['id'] != $_POST['usuario_id']) {
    echo json_encode([
        "Alerta" => "simple",
        "Titulo" => "Acción no autorizada",
        "Texto" => "No tienes permiso para actualizar este usuario.",
        "Tipo" => "error"
    ]);
    exit;
}


$id = limpiar_cadena($_POST['usuario_id']);

//Verificar el usuario
$check_usuario = conexion();
$check_usuario = $check_usuario->query("SELECT * FROM usuarios
    WHERE usuario_id='$id'");

if ($check_usuario->rowCount() <= 0) {
    echo '<div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    El usuario no existe en el sistema.
</div>
';
    exit();
} else {
    $datos = $check_usuario->fetch();
    if (!$datos || !is_array($datos)) {
        echo '<div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Los datos del usuario no se pudieron recuperar correctamente.
        </div>';
        exit();
    }
}
$check_usuario = null;

$admin_usuario = limpiar_cadena($_POST['administrador_usuario']);
$admin_clave = limpiar_cadena($_POST['administrador_clave']);

//Verificando campos obligatorios
if ($admin_usuario == "" || $admin_clave == "") {
    echo '<div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios, que
            corresponden a su USUARIO y CLAVE.
        </div>
    ';
    exit();
}


// Verificando integridad de los datos
if (verificar_datos("[a-zA-Z0-9]{4,20}", $admin_usuario)) {
    echo '<div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Su USUARIO no coincide con el formato solicitado
</div>
';
    exit();
}

// Verificando integridad de los datos
if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $admin_clave)) {
    echo '<div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Su CLAVE no coincide con el formato solicitado
</div>
';
    exit();
}

//Verificando admin
$check_admin = conexion();
$check_admin = $check_admin->query("SELECT usuario_usuario, usuario_clave
FROM usuarios WHERE usuario_usuario='$admin_usuario' AND 
usuario_id='" . $_SESSION['id'] . "'");
if ($check_admin->rowCount() == 1) {
    $check_admin = $check_admin->fetch();

    if (
        $check_admin['usuario_usuario'] != $admin_usuario ||
        !password_verify($admin_clave, $check_admin['usuario_clave'])
    ) {
        echo '<div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        USUARIO o CLAVE de sesion incorrectos.
    </div>
    ';
        exit();
    }
} else {
    echo '<div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    USUARIO o CLAVE de sesion incorrectos.
</div>
';
    exit();
}
$check_admin = null;


// Sanitizar y validar datos recibidos del formulario para el empleado
$nombre = validar_campo($_POST['empleado_nombre'], '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}$/');
$apellido = validar_campo($_POST['empleado_apellido'], '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}$/');
$dni = validar_campo($_POST['empleado_dni'], '/^\d{8,10}$/');
$telefono = validar_campo($_POST['empleado_telefono'], '/^\d{10}$/');
$area_id = filter_var($_POST['area_id'], FILTER_VALIDATE_INT);

  // Validar y procesar los datos del usuario
  $usuario = validar_campo($_POST['usuario_usuario'], '/^[a-zA-Z0-9]{4,20}$/');
  $clave_1 = limpiar_cadena($_POST['usuario_clave_1']);
  $clave_2 = limpiar_cadena($_POST['usuario_clave_2']);//usuario_clave_repetida
  $email = filter_var(trim($_POST['usuario_email']), FILTER_VALIDATE_EMAIL);
  // Validar si rol_id está definido
if (isset($_POST['rol_id']) && $_SESSION['rol'] == 1) {
    $rol_id = limpiar_cadena($_POST['rol_id']);
} else {
    // Usar el valor existente de la base de datos si no se envió un nuevo rol_id
    $rol_id = $datos['rol_id'];
}

  $genero = $_POST['empleado_genero'];


// Validar los campos obligatorios del empleado
if ($nombre == "" || $apellido == "" || $dni == "" || $telefono == "" || $area_id == "" || $genero == "") {

    echo '<div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No has llenado todos los campos que son obligatorios
</div>
';
exit();
}



// Verificando integridad de los datos
if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
    echo '<div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    El NOMBRE no coincide con el formato solicitado
</div>
';
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
    echo '<div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    El APELLIDO no coincide con el formato solicitado
</div>
';
    exit();
}

if (verificar_datos("^\d{8,10}$", $dni)) {
    echo '<div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    El DNI no coincide con el formato solicitado
</div>
';
    exit();
}
if (verificar_datos("^\d{10}$", $telefono)) {
    echo '<div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    El TELEFONO no coincide con el formato solicitado
</div>
';
    exit();
}

//Verificando el Email
if ($email != "" && isset($datos['usuario_email']) && $email != $datos['usuario_email']) {

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $check_email = conexion();
        $check_email = $check_email->query("SELECT usuario_email FROM usuarios WHERE usuario_email='$email'");
        if ($check_email->rowCount() > 0) { //esto no devolvera cuantos registros se seleccionó con la consulta de arriba
            echo '<div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El email ingresado ya se encuentra registrado, por favor
                    elija otro.
                </div>
            ';
            exit();
        }
        $check_email = null;
    } else {
        echo '<div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El EMAIL ingresado no es valido
    </div>
';
        exit();
    }
}


// Verificando Usuario
if (!empty($usuario)) {
    if (verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
        echo '<div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El USUARIO no coincide con el formato solicitado.
            </div>';
        exit();
    }
} else {
    echo '<div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El campo USUARIO no puede estar vacío.
        </div>';
    exit();
}


#Verificando claves#
if ($clave_1 != "" || $clave_2 != "") {
    if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_2)) {
        echo '<div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        Las CLAVES no coinciden con el formato solicitado
    </div>
';
        exit();
    } else {
        if ($clave_1 != $clave_2) {
            echo '<div class="notification is-danger is-light">
                                <strong>¡Ocurrio un error inesperado!</strong><br>
                                Las contraseñas no coinciden.
                            </div>
                        ';
            exit();
        } else {
            $clave = password_hash($clave_1, PASSWORD_BCRYPT, ["cost" => 10]);
        }
    }
} else {
    $clave = $datos['usuario_clave'];
}


// Conexión a la base de datos
$actualizar_usuario = conexion();

// Consulta preparada para actualizar datos en las tablas `usuarios` y `empleados`
$actualizar_usuario = $actualizar_usuario->prepare("
    UPDATE empleados 
    INNER JOIN usuarios ON empleados.empleado_nroLegajo = usuarios.empleado_id
    SET 
        empleados.empleado_nombre = :empleado_nombre,
        empleados.empleado_apellido = :empleado_apellido,
        empleados.empleado_dni = :empleado_dni,
        empleados.empleado_telefono = :empleado_telefono,
        empleados.empleado_genero = :empleado_genero,
        empleados.area_id = :area_id,
        usuarios.usuario_usuario = :usuario_usuario,
        usuarios.usuario_clave = :usuario_clave,
        usuarios.usuario_email = :usuario_email,
        usuarios.rol_id = :rol_id
    WHERE usuarios.usuario_id = :usuario_id
");

// Marcadores para la consulta
$marcadores = [
    ":empleado_nombre" => $nombre,
    ":empleado_apellido" => $apellido,
    ":empleado_dni" => $dni,
    ":empleado_telefono" => $telefono,
    ":empleado_genero" => $genero,
    ":area_id" => $area_id,
    ":usuario_usuario" => $usuario,
    ":usuario_clave" => $clave,
    ":usuario_email" => $email,
    ":rol_id" => $rol_id,
    ":usuario_id" => $id
];

// Ejecutar la consulta y verificar el resultado
if ($actualizar_usuario->execute($marcadores)) {
    echo '<div class="alert alert-success" role="alert">
    <strong>¡USUARIO ACTUALIZADO!</strong><br>
    El usuario se actualizó con éxito.
</div>';
} else {
    echo '<div class="notification is-danger is-light">
    <strong>¡Ocurrió un error inesperado!</strong><br>
    No se pudo actualizar el usuario, por favor intente nuevamente.
</div>';
}

// Cerrar la conexión
$actualizar_usuario = null;

