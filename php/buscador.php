<?php
    $modulo_buscador=limpiar_cadena($_POST['modulo_buscador']);

    $modulos=["usuario",/* "categoria", */"producto"];

    if(in_array($modulo_buscador,$modulos)){ //Pregunta si usuario se encuentra en el array modulos

        $modulos_url=[
            "usuario"=>"usuarios_search",
            /* "categoria"=>"category_search", */
            "producto"=>"product_search"
        ];

        $modulos_url=$modulos_url[$modulo_buscador]; //A $modulos_url se le asigna el Nombre de la vista donde vamos a recargar

        $modulo_buscador="busqueda_".$modulo_buscador;//A $modulo_buscador se le asigna el Nombre de la variable de sesion que vamos  a utilizar
    
        //Iniciar busqueda
        if(isset($_POST['txt_buscador'])){
            $txt=limpiar_cadena($_POST['txt_buscador']);

            if($txt==""){
                echo '<div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Introduce un término de busqueda.
            </div>
            ';
            }else{
                if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ$@._\- ]{1,50}",$txt)){
                            echo '<div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El término de busqueda no coincide con el formato solicitado.
                    </div>
                    ';
                }else{
                    $_SESSION[$modulo_buscador]=$txt;
                    header("Location: index.php?vista=$modulos_url",true,303);
                    exit();               
                }
            }
        }


        //Eliminar busqueda
        if(isset($_POST['eliminar_buscador'])){
            unset($_SESSION[$modulo_buscador]);
            header("Location: index.php?vista=$modulos_url",true,303);
            exit(); 
        }
    
    }else{
        echo '<div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No podemos procesar la petición.
</div>
';
    }











