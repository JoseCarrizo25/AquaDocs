<?php
// Verificar si el rol está definido en la sesión
if (!isset($_SESSION['rol'])) {
    echo '<div class="alert alert-danger">Error: Usuario no autenticado.</div>';
    exit();
}

// Mapeo de rol_id a nombres de roles
$rol_map = [
    1 => 'administrador',
    2 => 'usuario',
    3 => 'auditor',
];

// Validar el rol actual y asignar el nombre correspondiente
if (isset($rol_map[$_SESSION['rol']])) {
    $rol_actual = $rol_map[$_SESSION['rol']];
} else {
    echo '<div class="alert alert-danger">Error: Rol no reconocido.</div>';
    exit();
}

// Definir el array con las secciones del menú para cada rol
$menu_secciones = [
    'administrador' => [
        'Inicio' => 'index.php?vista=home',
        'Archivos' => 'index.php?vista=archivos_view',
        'Usuarios' => [
            'Agregar Usuarios' => 'index.php?vista=usuarios_view',
            'Lista de Usuarios' => 'index.php?vista=usuarios_list',
            'Buscar Usuarios' => 'index.php?vista=usuarios_search',
        ],
        'Expedientes' => [
            'Agregar Expedientes' => 'index.php?vista=expedientes_view',
            'Lista de Expedientes' => 'index.php?vista=expedientes_list',
            'Buscar Expedientes' => 'index.php?vista=expedientes_search',
        ],
        'Configuración' => 'index.php?vista=configuracion_view',
        'Archivos Compartidos' => 'index.php?vista=shared_files',
        'Carpetas Compartidas' => 'index.php?vista=shared_folders',
    ],
    'auditor' => [
        'Inicio' => 'index.php?vista=home',
        'Archivos' => 'index.php?vista=archivos_view',
        'Usuarios' => [
            'Lista de Usuarios' => 'index.php?vista=usuarios_list',
            'Buscar Usuarios' => 'index.php?vista=usuarios_search',
        ],
        'Expedientes' => [
            'Lista de Expedientes' => 'index.php?vista=expedientes_list',
            'Buscar Expedientes' => 'index.php?vista=expedientes_search',
        ],
        'Archivos Compartidos' => 'index.php?vista=shared_files',
    ],
    'usuario' => [
        'Inicio' => 'index.php?vista=home',
        'Archivos' => 'index.php?vista=archivos_view',
        'Usuarios' => [
            'Lista de Usuarios' => 'index.php?vista=usuarios_list',
            'Buscar Usuarios' => 'index.php?vista=usuarios_search',
        ],
        'Expedientes' => [
            'Agregar Expedientes' => 'index.php?vista=expedientes_view',
            'Lista de Expedientes' => 'index.php?vista=expedientes_list',
            'Buscar Expedientes' => 'index.php?vista=expedientes_search',
        ],
        'Archivos Compartidos' => 'index.php?vista=shared_files',
        'Carpetas Compartidas' => 'index.php?vista=shared_folders',
    ],
];
?>

<!-- Generar el sidebar dinámicamente -->
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse" style="background-color: #c8dce8;">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
            <?php
            // Verificar si el rol actual tiene secciones asignadas en el menú
            if (isset($menu_secciones[$rol_actual])) {
                foreach ($menu_secciones[$rol_actual] as $seccion => $enlace) {
                    if (is_array($enlace)) {
                        echo '<li class="nav-item">';
                        echo '<button class="nav-link dropdown-btn">';
                        // Asignar ícono para la sección "Expedientes"
                        $icono_seccion = ($seccion == 'Expedientes') ? 'folder' : 'user';
                        echo '<span data-feather="' . $icono_seccion . '"></span> ' . $seccion . ' <span class="caret">&#9660;</span>';
                        echo '</button>';
                        echo '<ul class="dropdown-container">';
                        foreach ($enlace as $subseccion => $sublink) {
                            $icono = '';
                            // Asignar íconos específicos para las subsecciones
                            if ($subseccion == 'Agregar Expedientes') {
                                $icono = 'folder-plus'; // Para Agregar
                            } elseif ($subseccion == 'Agregar Usuarios') {
                                $icono = 'user-plus'; // Para Agregar
                            } elseif ($subseccion == 'Lista de Usuarios' || $subseccion == 'Lista de Expedientes') {
                                $icono = 'list'; // Para Lista
                            } elseif ($subseccion == 'Buscar Usuarios' || $subseccion == 'Buscar Expedientes') {
                                $icono = 'search'; // Para Buscar
                            }
                            echo '<li><a class="dropdown-item" href="' . $sublink . '" target="_self">';
                            echo '<span data-feather="' . $icono . '"></span> ' . $subseccion;
                            echo '</a></li>';
                        }
                        echo '</ul>';
                        echo '</li>';
                    } else {
                        $icono = '';
                        if ($seccion == 'Inicio') {
                            $icono = 'home';
                        } elseif ($seccion == 'Archivos') {
                            $icono = 'file';
                        } elseif ($seccion == 'Configuración') {
                            $icono = 'settings';
                        } elseif ($seccion == 'Archivos Compartidos') {
                            $icono = 'bar-chart-2';
                        } elseif ($seccion == 'Carpetas Compartidas') {
                            $icono = 'layers';
                        }

                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="' . $enlace . '" target="_self">';
                        echo '<span data-feather="' . $icono . '"></span> ' . $seccion;
                        echo '</a>';
                        echo '</li>';
                    }
                }
            } else {
                echo '<div class="alert alert-warning">No tiene permisos asignados para este menú.</div>';
            }
            ?>
        </ul>
        <!-- Mostrar el tipo de usuario al final del sidebar -->
        <div class="mt-3 text-center">
            <?php
            echo '<div class="alert alert-info text-uppercase" style="text-align: center;">Rol actual: ' . strtoupper($rol_actual) . '</div>';
            ?>
        </div>

    </div>
</nav>