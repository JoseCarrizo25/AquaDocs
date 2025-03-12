
<div class="container-fluid">
    <div class="row">
      

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div class="d-flex flex-column justify-content-between align-items-start pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Inicio</h1>
          <h2 class="subtitle">  <?php
            // Obtener el género del usuario desde la sesión
            $genero = $_SESSION['genero']; // Variable configurada al iniciar sesión
            $nombreCompleto = $_SESSION['nombre'] . " " . $_SESSION['apellido'];

            // Definir el saludo según el género
            if ($genero === 'Masculino') {
                echo "¡Bienvenido $nombreCompleto!";
            } elseif ($genero === 'Femenino') {
                echo "¡Bienvenida $nombreCompleto!";
            } else {
                echo "¡Bienvenido $nombreCompleto!";
            }
            ?></h2>
      </div>


        <div class="card-deck">
          <!-- Usuarios -->
          <div class="card">
            <img src="./img/users-solid.svg" class="card-img-top" alt="Users">
            <div class="card-body">
              <a href="index.php?vista=usuarios_list" target="_self">
                <button type="button" class="btn btn-primary" id="notificador">
                  Usuarios <!-- <span class="badge badge-light" id="numerito">2</span> -->
                </button>
              </a>
            </div>
          </div>

          <!-- Archivos -->
          <div class="card">
            <img src="./img/file-solid.svg" class="card-img-top" alt="Files">
            <div class="card-body">
              <a href="index.php?vista=shared_files" target="_self">
                <button type="button" class="btn btn-primary" id="notificador">
                  Archivos <!-- <span class="badge badge-light" id="numerito">4</span> -->
                </button>
              </a>
            </div>
          </div>

          <!-- Carpetas -->
          <div class="card">
            <img src="./img/folder-solid.svg" class="card-img-top" alt="Folder">
            <div class="card-body">
              <a href="index.php?vista=shared_folders" target="_self">
                <button type="button" class="btn btn-primary" id="notificador">
                  Carpetas <!-- <span class="badge badge-light" id="numerito">2</span> -->
                </button>
              </a>
            </div>
          </div>
        </div>

        <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>Lista de Expedientes</h2>
        </div>
        <div class="table-responsive">
          <table class="table thead-dark table-sm">
            <thead>
              <tr>
                <th>Código</th>
                <th>Número de Expediente</th>
                <th>Área</th>
                <th>Asunto</th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Descarga</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>G10</td>
                <td>2752</td>
                <td>Obras y proyectos</td>
                <td>Texto</td>
                <td>10/23</td>
                <td>Certificado</td>
              </tr>
              <tr>
                <td>G11</td>
                <td>7357</td>
                <td>Estudios Hídricos</td>
                <td>Texto</td>
                <td>01/24</td>
                <td>Permisos</td>
              </tr>
              <tr>
                <td>G12</td>
                <td>2957</td>
                <td>Control y Fiscalización</td>
                <td>Texto</td>
                <td>02/24</td>
                <td>Solicitud</td>
              </tr>
              <tr>
                <td>G13</td>
                <td>6634</td>
                <td>Mantenimiento</td>
                <td>Texto</td>
                <td>03/24</td>
                <td>Certificado</td>
              </tr>
              <tr>
                <td>G14</td>
                <td>1289</td>
                <td>Agua y Saneamiento</td>
                <td>Texto</td>
                <td>04/24</td>
                <td>Pago</td>
              </tr>
              <tr>
            </tbody>
          </table>
        </div>

      </main>
    </div>
  </div>