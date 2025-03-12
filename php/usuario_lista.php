<!DOCTYPE html>
<html lang="en">

<body>
    <style>
        .resaltado {
            background-color: orange;
            /* Color de fondo */
            color: #000;
            /* Color del texto */
            font-weight: bold;
            /* Negrita para destacar */
            padding: 2px 4px;
            /* Espaciado alrededor del texto */
            border-radius: 4px;
            /* Bordes redondeados */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            /* Sombras para resaltar más */
        }
    </style>
</body>

</html>

<?php
// Verificar si el rol está definido en la sesión
if (!isset($_SESSION['rol'])) {
    echo '<div class="alert alert-danger">Error: Usuario no autenticado.</div>';
    exit();
}

// Calcular el inicio del paginador en función de la página actual y la cantidad de registros por página
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
$tabla = ""; // Inicializar variable para almacenar el contenido de la tabla

// Consulta base para datos de usuarios y empleados
$consulta_base = "
    SELECT usuarios.usuario_id, usuarios.usuario_usuario, usuarios.usuario_email, usuarios.estado,
           empleados.empleado_nombre, empleados.empleado_apellido, empleados.empleado_telefono, empleados.empleado_dni
    FROM usuarios
    LEFT JOIN empleados ON usuarios.empleado_id = empleados.empleado_nroLegajo
    WHERE usuarios.usuario_id != :usuario_id 
";

// Verificar si hay una búsqueda activa
if (isset($busqueda) && $busqueda != "") {
    $consulta_datos = $consulta_base . "
        AND (
            usuarios.usuario_usuario LIKE :busqueda OR 
            usuarios.usuario_email LIKE :busqueda OR 
            empleados.empleado_nombre LIKE :busqueda OR 
            empleados.empleado_apellido LIKE :busqueda OR 
            empleados.empleado_telefono LIKE :busqueda OR 
            empleados.empleado_dni LIKE :busqueda
        )
        ORDER BY usuarios.usuario_usuario ASC
        LIMIT :inicio, :registros
    ";
    $consulta_total = "
        SELECT COUNT(usuarios.usuario_id)
        FROM usuarios
        LEFT JOIN empleados ON usuarios.empleado_id = empleados.empleado_nroLegajo
        WHERE usuarios.usuario_id != :usuario_id 
        AND usuarios.estado = 1
        AND (
            usuarios.usuario_usuario LIKE :busqueda OR 
            usuarios.usuario_email LIKE :busqueda OR 
            empleados.empleado_nombre LIKE :busqueda OR 
            empleados.empleado_apellido LIKE :busqueda OR 
            empleados.empleado_telefono LIKE :busqueda OR 
            empleados.empleado_dni LIKE :busqueda
        )
    ";
} else {
    $consulta_datos = $consulta_base . "
        ORDER BY usuarios.usuario_usuario ASC
        LIMIT :inicio, :registros
    ";
    $consulta_total = "
        SELECT COUNT(usuarios.usuario_id)
        FROM usuarios
        LEFT JOIN empleados ON usuarios.empleado_id = empleados.empleado_nroLegajo
        WHERE usuarios.usuario_id != :usuario_id
    ";
}

// Conectar a la base de datos
$conexion = conexion();

// Preparar y ejecutar la consulta de datos
$stmt_datos = $conexion->prepare($consulta_datos);
$stmt_datos->bindValue(':usuario_id', $_SESSION['id'], PDO::PARAM_INT);
if (isset($busqueda) && $busqueda != "") {
    $stmt_datos->bindValue(':busqueda', "%$busqueda%", PDO::PARAM_STR);
}
$stmt_datos->bindValue(':inicio', $inicio, PDO::PARAM_INT);
$stmt_datos->bindValue(':registros', $registros, PDO::PARAM_INT);
$stmt_datos->execute();
$datos = $stmt_datos->fetchAll(PDO::FETCH_ASSOC);

// Preparar y ejecutar la consulta para contar el total de registros
$stmt_total = $conexion->prepare($consulta_total);
$stmt_total->bindValue(':usuario_id', $_SESSION['id'], PDO::PARAM_INT);
if (isset($busqueda) && $busqueda != "") {
    $stmt_total->bindValue(':busqueda', "%$busqueda%", PDO::PARAM_STR);
}
$stmt_total->execute();
$total = (int) $stmt_total->fetchColumn();

// Calcular el número de páginas
$Npaginas = ceil($total / $registros);

// Función para resaltar coincidencias
function resaltar_busqueda($texto, $busqueda)
{
    return str_ireplace($busqueda, "<span class='resaltado'>$busqueda</span>", $texto);
}

// Generar tabla
$tabla .= '
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover table-sm">
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>DNI</th>
';

// Mostrar las columnas de opciones solo si el usuario es Administrador
if ($_SESSION['rol'] == 1) {
    $tabla .= '<th colspan="2">Opciones</th>';
}
if ($_SESSION['rol'] == 1) {
    $tabla .= '<th>Estado</th>';
}

$tabla .= '
            </tr>
        </thead>
        <tbody>
';

// Si hay resultados
if ($total >= 1 && $pagina <= $Npaginas) {
    $contador = $inicio + 1;
    foreach ($datos as $rows) {
        $tabla .= '
        <tr class="text-center">
            <td>' . $contador . '</td>
            <td>' . (isset($busqueda) ? resaltar_busqueda(htmlspecialchars($rows['empleado_nombre']), $busqueda) : htmlspecialchars($rows['empleado_nombre'])) . '</td>
            <td>' . (isset($busqueda) ? resaltar_busqueda(htmlspecialchars($rows['empleado_apellido']), $busqueda) : htmlspecialchars($rows['empleado_apellido'])) . '</td>
            <td>' . (isset($busqueda) ? resaltar_busqueda(htmlspecialchars($rows['usuario_usuario']), $busqueda) : htmlspecialchars($rows['usuario_usuario'])) . '</td>
            <td>' . (isset($busqueda) ? resaltar_busqueda(htmlspecialchars($rows['usuario_email']), $busqueda) : htmlspecialchars($rows['usuario_email'])) . '</td>
            <td>' . (isset($busqueda) ? resaltar_busqueda(htmlspecialchars($rows['empleado_telefono']), $busqueda) : htmlspecialchars($rows['empleado_telefono'])) . '</td>
            <td>' . (isset($busqueda) ? resaltar_busqueda(htmlspecialchars($rows['empleado_dni']), $busqueda) : htmlspecialchars($rows['empleado_dni'])) . '</td>
        ';

        // Mostrar las opciones solo si el usuario es Administrador
        if ($_SESSION['rol'] == 1) {
            $estado_label = ($rows['estado'] == 1) ? 'Activo' : 'Inactivo';
            $estado_clase = ($rows['estado'] == 1) ? 'badge bg-success' : 'badge bg-warning';
            $nuevo_estado = ($rows['estado'] == 1) ? 0 : 1;
            $boton_estado = ($rows['estado'] == 1) ? 'Desactivar' : 'Activar';
            $clase_boton = ($rows['estado'] == 1) ? 'btn-warning' : 'btn-primary';
            $tabla .= '
            <td>
                <a href="index.php?vista=user_update&user_id_up=' . $rows['usuario_id'] . '" class="btn btn-success rounded-pill btn-sm">Actualizar</a>
            </td>
             <td>
           
            <a href="' . $url . $pagina . '&user_id_del=' . $rows['usuario_id'] . '&estado=' . $nuevo_estado . '" 
               class="btn ' . $clase_boton . ' rounded-pill btn-sm" 
               onclick="return confirm(\'¿Está seguro que desea cambiar el estado de este usuario?\');">
               ' . $boton_estado . '
            </a>
        </td>
             <td><span class="' . $estado_clase . '">' . $estado_label . '</span></td>
            ';
        }
/* <a href="index.php?vista=cambiar_estado&usuario_id=' . $rows['usuario_id'] . '&estado=' . $nuevo_estado . '"  */
        $tabla .= '</tr>';
        $contador++;
    }
} else {
    $tabla .= '
    <tr class="text-center">
        <td colspan="7">No hay registros en el sistema</td>
    </tr>
    ';
}

$tabla .= '</tbody></table></div>';

// Mostrar tabla
echo $tabla;

// Mostrar paginador
if ($total >= 1 && $pagina <= $Npaginas) {
    echo paginador_tablas($pagina, $Npaginas, $url, 7);
}
?>