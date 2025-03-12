<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Página no encontrada</title>
    <link rel="stylesheet" href="./CSS/404style.css">
</head>
<body class="text-center">
  <!-- Contenedor principal -->
  <div class="square circulo">
    <span></span>
    <span></span>
    <span></span>
    <div class="main-container">
        <section class="hero">
            <div class="hero-body">
                <h1 class="title">404</h1>
                <p class="subtitle">Oops... Página no encontrada</p>
                <p>La página que buscas no existe o fue movida.</p>

                <!-- Botones de navegación -->
                <div class="btn-container">
                    <a href="#" id="btn-back" class="btn btn-back">&#8678; Regresar atrás</a>
                    <a href="index.php?vista=home" class="btn btn-home">Ir al inicio &#8962;</a>
                </div>
            </div>
        </section>
    </div>

    <!-- Script para manejar el botón "Regresar atrás" -->
    <script>
        document.getElementById("btn-back").addEventListener("click", function(e) {
            e.preventDefault(); // Evita el comportamiento predeterminado del enlace
            window.history.back(); // Vuelve a la página anterior
        });
    </script>
    </form>
  </div>

</body>


















</head>
<body>
   
</body>
</html>
