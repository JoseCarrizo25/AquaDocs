<div class="container-fluid">
    <div class="row">


        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Buscar usuarios</h1>
            </div>

            <style>
                .input-group {
                    margin-top: 1rem;
                    margin-bottom: 1rem;
                }

                .btn:hover {
                    transform: scale(1.05);
                }
            </style>

            <div class="container pb-6 pt-6">
                <?php
                require_once "./php/main.php";

                if (isset($_POST['modulo_buscador'])) {
                    require_once "./php/buscador.php";
                }

                if (!isset($_SESSION['busqueda_usuario'])  && empty($_SESSION //si la variable de sesion no está definida y está vacia, se muestra el form para realizar la busqueda
                ['busqueda_usuario'])) {
                ?>
                    <!-- Formulario de búsqueda -->
                    <div class="row">
                        <div class="col-12">
                            <form action="" method="POST" autocomplete="off">
                                <input type="hidden" name="modulo_buscador" value="usuario">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        name="txt_buscador"
                                        class="form-control rounded-pill"
                                        placeholder="¿Qué estás buscando?"
                                        pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ$@._\- ]{1,50}"
                                        maxlength="50">
                                    <button type="submit" class="btn btn-info rounded-pill"
                                        style="margin-left: 5px;">Buscar</button>
                                </div>
                            </form>
                        </div>
                    </div>

                <?php } else { ?>

                    <div class="row">
                        <div class="col-12 text-center mt-4 mb-4">
                            <form action="" method="POST" autocomplete="off">
                                <input type="hidden" name="modulo_buscador" value="usuario">
                                <input type="hidden" name="eliminar_buscador" value="usuario">
                                <p>Estás buscando <strong>“<?php echo $_SESSION['busqueda_usuario']; ?>”</strong></p>
                                <br>
                                <button type="submit" class="btn btn-danger rounded-pill">Eliminar búsqueda</button>
                            </form>
                        </div>
                    </div>

                <?php

                    //Eliminar usuario
                    if (isset($_GET['user_id_del'])) {
                        require_once "./php/usuario_eliminar.php";
                    }

                    if (!isset($_GET['page'])) {
                        $pagina = 1; //si no viene definida la variable se crea y vale 1
                    } else {
                        $pagina = (int) $_GET['page']; //si está definida y tiene un valor menor a 1 ya sea 0 o negativo se colocará la pagina 1
                        if ($pagina <= 1) {
                            $pagina = 1;
                        }
                    }

                    $pagina = limpiar_cadena($pagina);
                    $url = "index.php?vista=usuarios_search&page=";
                    $registros = 15;
                    $busqueda = $_SESSION['busqueda_usuario'];

                    require_once "./php/usuario_lista.php";
                }
                ?>
            </div>


        </main>
    </div>
</div>