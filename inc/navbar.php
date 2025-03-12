<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="index.php?vista=home" style="color: orange; background: #0000;"><img
        src="./img/Posible_logo-removebg-preview.png" width="30" height="30" class="d-inline-block align-top" alt="Logo">
      <span style="color: rgb(37, 142, 207);">Aqua</span> Docs
    </a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse"
      data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <input class="form-control form-control-dark w-auto" type="text" placeholder="Buscar" aria-label="Search">

    <div class="navbar-nav ms-auto">
  <div class="nav-item">
     <a href="index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id']; ?>" class="btn btn-primary rounded-pill me-2">
      Mi cuenta
    </a>
       <a href="logout.php" class="btn btn-outline-primary rounded-pill">
      Salir
    </a>
  </div>
</div>

  </nav>