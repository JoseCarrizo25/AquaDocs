// Selecciona todos los formularios con la clase "FormularioAjax"
const formularios_ajax = document.querySelectorAll(".FormularioAjax");

// Función principal para manejar el envío del formulario
function enviar_formulario_ajax(e) {
    e.preventDefault(); // Prevenir el envío por defecto del formulario

    // Mostrar el modal de confirmación de Bootstrap
    let myModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    myModal.show();

    // Retornar una promesa que espera la acción del usuario (aceptar o cancelar)
    return new Promise((resolve, reject) => {
        // Función para cerrar el modal y resolver la promesa con la elección del usuario
        const resolveModal = (result) => {
            myModal.hide(); // Ocultar el modal
            resolve(result); // Resolver la promesa con el resultado (true o false)
        };

        // Configurar el botón "Aceptar" para confirmar el envío
        document.getElementById('acceptButton').onclick = () => resolveModal(true);
        // Configurar el botón "Cancelar" para cancelar el envío
        document.getElementById('cancelButton').onclick = () => resolveModal(false);
    }).then(enviar => {
        if (enviar) {
            // Preparar los datos para el envío si el usuario confirma
            let formulario = e.target; // Formulario actual que disparó el evento
            let data = new FormData(formulario); // Recoger los datos del formulario
            let method = formulario.getAttribute("method"); // Obtener el método (POST/GET)
            let action = formulario.getAttribute("action"); // Obtener la URL de destino

            // Configuración para la solicitud Fetch
            let config = {
                method: method, // Método HTTP
                mode: 'cors', // Permitir solicitudes entre dominios
                cache: 'no-cache', // No usar cache
                body: data, // Cuerpo de la solicitud con los datos del formulario
            };

            // Enviar la solicitud utilizando Fetch
            fetch(action, config)
                .then(respuesta => {
                    if (!respuesta.ok) {
                        // Lanza un error si la respuesta HTTP no es satisfactoria
                        throw new Error("Error en la solicitud: " + respuesta.statusText);
                    }
                    return respuesta.text(); // Convertir la respuesta a texto
                })
                .then(respuesta => {
                    // Mostrar la respuesta del servidor en el contenedor designado
                    let contenedor = document.querySelector(".form-rest");
                    contenedor.innerHTML = respuesta;
                })
                .catch(error => {
                    // Manejo de errores en la solicitud Fetch
                    console.error("Error en el envío del formulario:", error);
                    alert("Ocurrió un error. Por favor, inténtalo de nuevo.");
                });
        } else {
            // Acción si el usuario cancela el envío del formulario
            console.log('Formulario no enviado');
        }
    });
}

// Asignar el evento "submit" a cada formulario encontrado
formularios_ajax.forEach(formulario => {
    formulario.addEventListener("submit", enviar_formulario_ajax);
});

document.addEventListener('DOMContentLoaded', () => {
    const messageDiv = document.querySelector('.form-rest');

    if (messageDiv) {
        // Observa cambios en el contenido del mensaje
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList' && messageDiv.innerHTML.trim() !== '') {
                    // Desplaza hacia el mensaje si tiene contenido
                    messageDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        });

        // Configura el observador
        observer.observe(messageDiv, { childList: true });
    }
});

