document.addEventListener("DOMContentLoaded", () => {

    const body = document.body;
    const toggleBtn = document.getElementById("themeToggle");
    const icon = toggleBtn.querySelector("i");

    // Cargar tema guardado
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "dark") {
        body.classList.add("dark-mode");
        icon.classList.replace("bi-moon-fill", "bi-sun-fill");
    }

    // Evento click
    toggleBtn.addEventListener("click", () => {
        body.classList.toggle("dark-mode");

        const isDark = body.classList.contains("dark-mode");

        // Actualizar icono
        if (isDark) {
            icon.classList.replace("bi-moon-fill", "bi-sun-fill");
        } else {
            icon.classList.replace("bi-sun-fill", "bi-moon-fill");
        }

        // Guardar preferencia
        localStorage.setItem("theme", isDark ? "dark" : "light");
    });

});
