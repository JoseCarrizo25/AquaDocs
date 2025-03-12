<!-- Botón para regresar atrás -->
<p class="text-end pt-4 pb-4">
    <a href="#" id="notificador" class="btn btn-back">&larr; Regresar atrás</a>
</p>

<!-- Script para manejar el comportamiento del botón -->
<script type="text/javascript">
    // Selecciona el elemento con la clase .btn-back
    let btn_back = document.querySelector(".btn-back");

    // Agrega un evento al botón para detectar clics
    btn_back.addEventListener('click', function(e) {
        // Previene la acción predeterminada del enlace (recarga o redirección)
        e.preventDefault();
        // Utiliza la API de historial del navegador para regresar a la página anterior
        window.history.back();
    });
</script>
