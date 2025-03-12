<div class="container-fluid">
  <div class="row">
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">


      <?php
      require_once "./php/main.php";


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

      // Obtener el ID del usuario desde la URL y limpiarlo
      $id = (isset($_GET['user_id_up'])) ? $_GET['user_id_up'] : 0;
      $id = limpiar_cadena($id);

      // Validar que el usuario tiene permiso para modificar este ID
      if ($_SESSION['rol'] != 1 && $_SESSION['id'] != $id) {
        echo '<div class="notification is-danger is-light mb-6 mt-16">No tienes permiso para modificar este usuario.</div>';
        exit; // Detener la ejecución
      }
      ?>
      <div class="container-fluid mb-6">
        <?php if ($id == $_SESSION['id']) { ?>
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Actualizar datos de Mi cuenta</h1>
          </div>
        <?php } else { ?>

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Actualizar usuario</h1>
          </div>
        <?php } ?>
      </div>

      <div class="container pb-1 pt-1">
        <?php
        include "./inc/btn_back.php";

        // Realizar la consulta para obtener datos del usuario
        $check_usuario = conexion();
        $check_usuario = $check_usuario->query(
          "SELECT usuarios.usuario_id, usuarios.usuario_usuario, usuarios.usuario_email,
                        empleados.empleado_nombre, empleados.empleado_apellido, empleados.empleado_dni,
                        empleados.empleado_telefono, empleados.empleado_genero, empleados.area_id, usuarios.rol_id
                        FROM usuarios
                        LEFT JOIN empleados ON usuarios.empleado_id = empleados.empleado_nroLegajo
                        WHERE usuarios.usuario_id = '$id' AND usuarios.estado = 1"
        );

        // Verificar si el usuario existe en la base de datos
        if ($check_usuario->rowCount() > 0) {
          $datos = $check_usuario->fetch();
        ?>
          <div class="form-rest mb-6 mt-6"></div>
          <!-- Mostrar formulario para actualizar usuario -->
          <form action="./php/usuario_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off">
            <!-- Campo oculto para el ID del usuario -->
            <input type="hidden" value="<?php echo $datos['usuario_id']; ?>" name="usuario_id" required>
            <!-- Campo para nombres -->
            <div class="row mb-2">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="empleado_nombre">Nombres</label>
                  <input type="text" class="form-control" id="empleado_nombre" name="empleado_nombre"
                    value="<?php echo $datos['empleado_nombre']; ?>"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                </div>
              </div>

              <!-- Campo para apellidos -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="empleado_apellido">Apellidos</label>
                  <input type="text" class="form-control" id="empleado_apellido" name="empleado_apellido"
                    value="<?php echo $datos['empleado_apellido']; ?>"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                </div>
              </div>

              <!-- Campo para DNI -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="empleado_dni">DNI</label>
                  <input type="text" class="form-control" id="empleado_dni" name="empleado_dni"
                    value="<?php echo $datos['empleado_dni']; ?>"
                    pattern="^\d{8,10}$" maxlength="8" required>
                </div>
              </div>
            </div>

            <!-- Campo para teléfono -->
            <div class="row mb-2">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="empleado_telefono">Teléfono</label>
                  <input type="text" class="form-control" id="empleado_telefono" name="empleado_telefono"
                    value="<?php echo $datos['empleado_telefono']; ?>"
                    pattern="^\d{10}$" maxlength="10" required>
                </div>
              </div>

              <!-- Campo para género -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="empleado_genero">Género</label>
                  <select class="form-control" id="empleado_genero" name="empleado_genero" required>
                    <option value="Masculino" <?php if ($datos['empleado_genero'] == 'Masculino') echo 'selected'; ?>>Masculino</option>
                    <option value="Femenino" <?php if ($datos['empleado_genero'] == 'Femenino') echo 'selected'; ?>>Femenino</option>
                    <option value="Otro" <?php if ($datos['empleado_genero'] == 'Otro') echo 'selected'; ?>>Otro</option>
                  </select>
                </div>
              </div>

              <!-- Campo para área -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="area_id">Área</label>

                  <select class="form-control" id="area_id" name="area_id" required>
                    <?php foreach ($areas as $area): ?>
                      <option value="<?= $area['area_id'] ?>"
                        <?= ($area['area_id'] == $datos['area_id']) ? 'selected' : '' ?>>
                        <?= $area['area_nombre'] ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>



            <!-- Campo para Email -->
            <div class="row mb-2">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="usuario_email">Email</label>
                  <input class="form-control"
                    type="email"
                    name="usuario_email"
                    id="usuario_email" value="<?php
                                              echo $datos['usuario_email'] ?> " maxlength="70">
                </div>
              </div>
            </div>

            <!-- Campo para rol -->
            <?php if ($_SESSION['rol'] == 1) { ?>
              <div class="row mb-4">
                <div class="col-md-12 d-flex justify-content-center">
                  <div class="form-group w-50">
                    <label for="rol_id">Rol</label>
                    <select class="form-control" id="rol_id" name="rol_id" required>
                      <?php foreach ($roles as $rol): ?>
                        <option value="<?= $rol['rol_id'] ?>" <?= ($rol['rol_id'] == $datos['rol_id']) ? 'selected' : '' ?>>
                          <?= $rol['rol_nombre'] ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
            <?php } ?>

            <!-- Campo para Usuario -->
            <div class="row mb-2">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="usuario_usuario">Usuario</label>
                  <input type="text" class="form-control" id="usuario_usuario" name="usuario_usuario"
                    value="<?php echo $datos['usuario_usuario']; ?>"
                    pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                </div>
              </div>


              <!-- Sección para ingresar la nueva clave -->
              <div class="col-md-4">
                <div class="form-group">
                  <!-- Etiqueta para el campo de la clave -->
                  <label for="usuario_clave_1">Clave</label>
                  <!-- Campo de entrada para la clave -->
                  <input type="password" class="form-control" id="usuario_clave_1" name="usuario_clave_1"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\$@.\-]).{7,100}" maxlength="100">
                </div>
              </div>
              <!-- Sección para repetir la nueva clave -->
              <div class="col-md-4">
                <div class="form-group">
                  <!-- Etiqueta para repetir la clave -->
                  <label for="usuario_clave_2">Repetir clave</label>
                  <!-- Campo de entrada para repetir la clave -->
                  <input type="password" class="form-control" id="usuario_clave_2" name="usuario_clave_2"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\$@.\-]).{7,100}" maxlength="100">
                </div>
              </div>
            </div>


            <?php echo '<div class="alert alert-info" role="alert">
        <strong>SI desea actualizar la clave de este usuario por favor llene los 2 campos. Si NO desea actualizar la clave deje los campos vacíos.</strong><br>
                    </div>';
            ?>


            <!-- Campo para ingresar el usuario administrador -->
            <div class="row mb-6">
              <div class="col-md-6">
                <div class="form-group">
                  <!-- Etiqueta para el usuario administrador -->
                  <label for="administrador_usuario">Usuario</label>
                  <!-- Campo de entrada para el usuario -->
                  <input type="text" class="form-control" id="administrador_usuario" name="administrador_usuario"
                    pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                </div>
              </div>
              <!-- Campo para ingresar la clave del administrador -->
              <div class="col-md-6">
                <div class="form-group">
                  <!-- Etiqueta para la clave del administrador -->
                  <label for="administrador_clave">Clave</label>
                  <!-- Campo de entrada para la clave del administrador -->
                  <input type="password" class="form-control" id="administrador_clave" name="administrador_clave"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$@.-]).{7,100}" maxlength="100" required>
                </div>
              </div>
            </div>


            <?php echo '<div class="alert alert-info" role="alert">
        <strong> Para poder actualizar los datos de este usuario por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión.</strong><br>
                    </div>';
            ?>


            <div class="text-center">
              <!-- Botón para actualizar -->
              <button type="submit" class="btn btn-success w-auto">Actualizar</button>
            </div>

          </form>

        <?php
        } else {
          include "./inc/error_alert.php";
        }
        $check_usuario = null;
        ?>
      </div>
    </main>
  </div>
</div>