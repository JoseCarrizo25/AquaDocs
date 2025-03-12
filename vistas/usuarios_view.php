<?php
// Verificar si el rol está definido en la sesión
if (!isset($_SESSION['rol'])) {
  echo '<div class="alert alert-danger">Error: Usuario no autenticado.</div>';
  exit();
}
//Verificar si el usuario que ingreso tiene el Rol de Admin
if ($_SESSION['rol'] == 1) {
  // Incluir archivo de conexión a la base de datos
  require_once './php/main.php';

  // Conectar a la base de datos
  $conexion = conexion();

  // Consultar áreas
  $query_areas = $conexion->prepare("SELECT area_id, area_nombre FROM areas");
  $query_areas->execute();
  $areas = $query_areas->fetchAll(PDO::FETCH_ASSOC);

  // Consultar roles
  $query_roles = $conexion->prepare("SELECT rol_id, rol_nombre FROM roles");
  $query_roles->execute();
  $roles = $query_roles->fetchAll(PDO::FETCH_ASSOC);

  // Cerrar la conexión a la base de datos
  $conexion = null;
?>

  <div class="container-fluid">
    <div class="row">
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Agregar usuarios</h1>
        </div>
        <div class="container pb-6 pt-6">
          <!-- Div para mostrar mensajes o errores -->
          <div class="form-rest mb-6 mt-6"></div>

          <!-- Formulario -->
          <form action="./php/usuario_guardar.php" method="POST" class="FormularioAjax formulario-usuario" autocomplete="off">
            <!-- Token CSRF para protección contra ataques de tipo Cross-Site Request Forgery -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

            <!-- Fila de Nombres y Apellidos del empleado -->
            <div class="row mb-4">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="empleado_nombre">Nombre</label>
                  <input class="form-control"
                    type="text"
                    name="empleado_nombre"
                    id="empleado_nombre"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}"
                    maxlength="40"
                    required
                    title="El nombre debe contener entre 3 y 40 caracteres alfabéticos.">
                  <!-- Este campo solicita el nombre del empleado y permite solo caracteres alfabéticos y espacios. -->
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="empleado_apellido">Apellido</label>
                  <input class="form-control"
                    type="text"
                    name="empleado_apellido"
                    id="empleado_apellido"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}"
                    maxlength="40"
                    required
                    title="El apellido debe contener entre 3 y 40 caracteres alfabéticos.">
                  <!-- Este campo solicita el apellido del empleado con las mismas validaciones que el nombre. -->
                </div>
              </div>
            </div>

            <!-- Fila de DNI, Teléfono y genero -->
            <div class="row mb-4">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="empleado_dni">DNI</label>
                  <input class="form-control"
                    type="text"
                    name="empleado_dni"
                    id="empleado_dni"
                    pattern="^\d{8,10}$"
                    maxlength="8"
                    required
                    title="El DNI debe contener entre 8 y 10 dígitos numéricos.">
                  <!-- Este campo solicita el DNI del empleado, aceptando solo dígitos. -->
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="empleado_telefono">Teléfono</label>
                  <input class="form-control"
                    type="text"
                    name="empleado_telefono"
                    id="empleado_telefono"
                    pattern="^\d{10}$"
                    maxlength="10"
                    required
                    title="El teléfono debe contener 10 dígitos numéricos.">
                  <!-- Este campo solicita el teléfono del empleado, aceptando solo números. -->
                </div>
              </div>
              <!-- Fila para el Género del empleado -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="empleado_genero">Género</label>
                  <select class="form-control" name="empleado_genero" id="empleado_genero" required>
                    <option value="">Seleccione un género</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Otro">Otro</option>
                  </select>
                  <!-- Este campo permite seleccionar el género del empleado. -->
                </div>
              </div>
            </div>

            <!-- Fila de Área del empleado -->
            <div class="row mb-4">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="area_id">Área</label>
                  <select class="form-control" name="area_id" id="area_id" required>
                    <option value="">Seleccione un área</option>
                    <?php foreach ($areas as $area): ?>
                      <option value="<?= $area['area_id'] ?>"><?= $area['area_nombre'] ?></option>
                    <?php endforeach; ?>
                  </select>
                  <!-- Este campo permite asignar un área específica al empleado. -->
                </div>
              </div>
            </div>

            <!-- Fila de Usuario y Claves -->
            <div class="row mb-4">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="usuario_usuario">Usuario</label>
                  <input class="form-control"
                    type="text"
                    name="usuario_usuario"
                    id="usuario_usuario"
                    pattern="[a-zA-Z0-9]{4,20}"
                    maxlength="20"
                    required
                    title="El usuario debe contener entre 4 y 20 caracteres alfanuméricos.">
                  <!-- Este campo solicita el nombre de usuario, restringido a caracteres alfanuméricos. -->
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="usuario_email">Email</label>
                  <input class="form-control"
                    type="email"
                    name="usuario_email"
                    id="usuario_email"
                    maxlength="70"
                    title="Introduce un correo electrónico válido.">
                  <!-- Este campo solicita un email válido para el usuario -->
                </div>
              </div>
            </div>

            <!-- Fila de Clave y Repetir clave -->
            <div class="row mb-4">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="usuario_clave_1">Clave</label>
                  <input class="form-control"
                    type="password"
                    name="usuario_clave_1"
                    id="usuario_clave_1"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$@.-]).{7,100}"
                    maxlength="100"
                    required
                    title="La clave debe tener al menos 7 caracteres, incluyendo una mayúscula, un número y un carácter especial ($@.-).">
                  <!-- Este campo solicita la clave del usuario con validaciones de seguridad adicionales. -->
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="usuario_clave_repetida">Repetir clave</label>
                  <input class="form-control"
                    type="password"
                    name="usuario_clave_repetida"
                    id="usuario_clave_repetida"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$@.-]).{7,100}"
                    maxlength="100"
                    required
                    title="Repite la clave anterior.">
                  <!-- Este campo verifica que la clave ingresada coincida con la clave principal. -->
                </div>
              </div>
            </div>

            <!-- Fila de Roles -->
            <div class="row mb-4">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="rol_id">Rol</label>
                  <select class="form-control" name="rol_id" id="rol_id" required>
                    <option value="">Seleccione un rol</option>
                    <?php foreach ($roles as $rol): ?>
                      <option value="<?= $rol['rol_id'] ?>"><?= $rol['rol_nombre'] ?></option>
                    <?php endforeach; ?>
                  </select>
                  <!-- Este campo permite asignar un rol al usuario registrado. -->
                </div>
              </div>
            </div>

            <!-- Botón de envío -->
            <div class="text-center">
              <button type="submit" class="btn btn-info btn-lg rounded-3">Guardar</button>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>
<?php } else { ?>
  <div class="container-fluid">
    <div class="row">
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex flex-column justify-content-center align-items-center pt-3 pb-2 mb-3">
          <div class="notification is-danger is-light mb-6 mt-16">
            <strong>¡Error!</strong><br>
            No tiene permisos para agregar a otro usuario.
          </div>
        <?php } ?>
        </div>
      </main>
    </div>
  </div>