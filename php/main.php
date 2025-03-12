<?php
// Archivo main.php para conexión y utilidades del sistema

// Conexión a la base de datos
function conexion() {
    try {
        // Configuración de conexión con PDO
        $pdo = new PDO('mysql:host=localhost;dbname=aquadocs2', 'root', 'pini1234');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configura el manejo de errores
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Configura el modo de obtención de datos por defecto
        return $pdo; // Devuelve la instancia PDO para ejecutar consultas
    } catch (PDOException $e) {
        // En caso de error, muestra un mensaje y termina el script
        die('Error en la conexión: ' . $e->getMessage());
    }
}

// Verificar datos
function verificar_datos($filtro, $cadena) {
    // Valida que la cadena cumpla con el patrón del filtro
    if (preg_match("/^" . $filtro . "$/", $cadena)) {
        return false; // No hay error
    } else {
        return true; // Hay error
    }
}
// Función para validar campos
function validar_campo($campo, $patron) {
    if (preg_match($patron, $campo)) {
        return $campo;
    } else {
        echo '<div class="notification is-danger is-light">
                <strong>¡Error de validación!</strong><br>
                El campo no cumple con el formato solicitado.
              </div>';
        exit();
    }
}

// Función para limpiar cadenas de texto
function limpiar_cadena($cadena) {
    // Elimina espacios en blanco al inicio y final
    $cadena = trim($cadena);
    // Elimina barras invertidas de una cadena con comillas escapadas
    $cadena = stripslashes($cadena);
    // Reemplaza patrones inseguros o sospechosos en la cadena
    $patrones = [
        "<script>", "</script>", "<script src", "<script type=", "SELECT * FROM", "DELETE FROM", 
        "INSERT INTO", "DROP TABLE", "DROP DATABASE", "TRUNCATE TABLE", "SHOW TABLES;", 
        "SHOW DATABASES;", "<?php", "?>", "--", "^", "<", "[", "]", "==", ";", "::"
    ];
    foreach ($patrones as $patron) {
        $cadena = str_ireplace($patron, "", $cadena);
    }
    // Asegura una limpieza adicional con las funciones trim y stripslashes
    $cadena = trim($cadena);
    $cadena = stripslashes($cadena);
    return $cadena; // Devuelve la cadena limpia
}

// Función para renombrar fotos
function renombrar_fotos($nombre) {
    // Reemplaza caracteres especiales o espacios por guiones bajos
    $patrones = [" ", "/", "#", "-", "$", ".", ","];
    foreach ($patrones as $patron) {
        $nombre = str_ireplace($patron, "_", $nombre);
    }
    // Agrega un sufijo único al nombre para evitar duplicados
    $nombre = $nombre . "_" . rand(0, 100);
    return $nombre; // Devuelve el nuevo nombre
}

// Función paginador para tablas con Bootstrap
function paginador_tablas($pagina, $Npaginas, $url, $botones) {
    // Inicia el código HTML del paginador
    $tabla = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';

    // Enlace para ir a la página anterior
    if ($pagina <= 1) {
        $tabla .= '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">Anterior</a></li>';
    } else {
        $tabla .= '<li class="page-item"><a class="page-link" href="' . $url . ($pagina - 1) . '">Anterior</a></li>';
        $tabla .= '<li class="page-item"><a class="page-link" href="' . $url . '1">1</a></li>';
        $tabla .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
    }

    // Botones para páginas en el rango
    $ci = 0;
    for ($i = $pagina; $i <= $Npaginas; $i++) {
        if ($ci >= $botones) break; // Limita la cantidad de botones a mostrar
        if ($pagina == $i) {
            $tabla .= '<li class="page-item active"><a class="page-link" href="' . $url . $i . '">' . $i . '</a></li>';
        } else {
            $tabla .= '<li class="page-item"><a class="page-link" href="' . $url . $i . '">' . $i . '</a></li>';
        }
        $ci++;
    }

    // Enlace para ir a la página siguiente
    if ($pagina == $Npaginas) {
        $tabla .= '<li class="page-item disabled"><a class="page-link" href="#">Siguiente</a></li>';
    } else {
        $tabla .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
        $tabla .= '<li class="page-item"><a class="page-link" href="' . $url . $Npaginas . '">' . $Npaginas . '</a></li>';
        $tabla .= '<li class="page-item"><a class="page-link" href="' . $url . ($pagina + 1) . '">Siguiente</a></li>';
    }

    $tabla .= '</ul></nav>'; // Cierra el HTML del paginador
    return $tabla; // Devuelve el código HTML completo
}
?>
