document.addEventListener("DOMContentLoaded", function () {
    const dropdownBtns = document.querySelectorAll(".dropdown-btn");

    dropdownBtns.forEach(btn => {
        // Restablecer estado inicial
        btn.classList.remove("active");
        const dropdown = btn.nextElementSibling;
        if (dropdown) {
            dropdown.style.display = "none"; // Asegurar que el menú esté oculto
        }

        // Manejar clics para alternar visibilidad
        btn.addEventListener("click", function () {
            this.classList.toggle("active");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        });
    });

    // Inicializar Feather Icons
    feather.replace(); // Esto reemplaza las etiquetas <span> con los iconos de Feather
});

