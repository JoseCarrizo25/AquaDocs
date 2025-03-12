  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="./CSS/signin.css">
</head>
<body class="text-center">
  <!-- Contenedor principal -->
  <div class="square circulo">
    <span></span>
    <span></span>
    <span></span>
    <!-- Formulario de inicio de sesión -->
    <form class="form-signin" method="POST">
      <!-- Logo -->
      <img class="mb-4" src="./img/Posible_logo-removebg-preview.png" alt="Logo">
      <!-- Título del sistema -->
      <p class="h3 mb-1 " style="color: orange;"><span1 style="color: rgb(37, 142, 207);">Aqua</span1> Docs</p>
      <!-- Encabezado del formulario -->
      <h1 class="h3 mb-3 font-weight-normal">Iniciar Sesión</h1>

      <!-- Entrada para el correo -->
      <div class="userInput">
        <img class="iconSession" src="./img/person.svg" alt="user" width="50" height="50">
        <label for="inputUsuario" class="sr-only">Usuario</label>
        <input type="text" name="login_usuario" id="inputUsuario" class="form-control" placeholder="Usuario o Correo" required autofocus 
        pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{50,100}$" maxlength="100">
      </div>

      <!-- Entrada para la contraseña -->
      <div class="userInput">
        <img class="mt-1 iconSession" src="./img/lock.svg" alt="password" width="50" height="50">
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" name="login_clave" id="inputPassword" class="form-control" placeholder="Contraseña" required 
          pattern="[a-zA-Z0-9$@.-]{4,30}" maxlength="30">
      </div>

      <!-- Checkbox para recordar sesión -->
      <div class="checkbox mb-3 mt-3">
        <label>
          <input type="checkbox" value="remember-me"> Recuérdame
        </label>
      </div>

      <!-- Botón de enviar -->
      <button class="btn btn-lg btn-primary btn-block" id="botonSesion" type="submit"><strong>Acceder</strong></button>

      <!-- Pie de página -->
      <p class="mt-3 mb-3"><strong>&copy;</strong> <strong>2025</strong></p>
      <?php
    #Verificacion si las variables del formulario traen texto o estan definidas
    if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
        require_once "./php/main.php";
        require_once "./php/iniciar_sesion.php";
    }

    ?>
    </form>
  </div>

</body>

