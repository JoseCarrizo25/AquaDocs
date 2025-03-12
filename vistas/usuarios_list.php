<div class="container-fluid">
    <div class="row">
      

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div
          class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Lista de usuarios</h1>
        </div>

        <div class="container pb-6 pt-6">

    <?php
    require_once "./php/main.php";

    include "./inc/btn_back.php";
    //Eliminar usuario
    if(isset($_GET['user_id_del'])){
        require_once "./php/usuario_eliminar.php"; 
     }
     

    //Verificacion para evitar errores en el paginado
    if(!isset($_GET['page'])){
        $pagina=1;//si no viene definida la variable se crea y vale 1
    }else{
        $pagina=(int) $_GET['page'];//si está definida y tiene un valor menor a 1 ya sea 0 o negativo se colocará la pagina 1
        if($pagina<=1){
            $pagina=1;
        }
    }

    $pagina=limpiar_cadena($pagina);
    $url="index.php?vista=usuarios_list&page=";
    $registros=15;
    $busqueda="";

    require_once "./php/usuario_lista.php";
    ?>


</div>