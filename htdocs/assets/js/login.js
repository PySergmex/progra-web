document.addEventListener("DOMContentLoaded", function() {
// Mostrar loader cuando se envía el formulario de inicio de sesión
const loginForm = document.querySelector("form[action='includes/validar.php']");

if (loginForm) {
    loginForm.addEventListener("submit", function() {
        const loader = document.getElementById("loader-overlay");
        if (loader) loader.classList.remove("d-none");
    });
}



    const tabs = document.querySelectorAll(".tab-btn");
    const formCard = document.querySelector(".form-card, .form-card1"); // Para Sign In y Sign Up

    // Aplica animación de entrada automáticamente
    if (formCard) {
        formCard.classList.add("fade-in");
    }

    tabs.forEach(btn => {
        btn.addEventListener("click", function(event) {
            event.preventDefault(); // Evita redirección instantánea

            if (!formCard) return;

            // Hacer fade-out antes del cambio
            formCard.style.opacity = "0";

            setTimeout(() => {
                // Detectar destino según texto del botón
                if (btn.textContent.includes("Sign Up")) {
                    window.location.href = "sign_up.php";
                } else {
                    window.location.href = "index.php";
                }
            }, 150);
        });
    });

});
