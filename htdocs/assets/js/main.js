// main.js - Script global de ACADEMIX
// Este archivo contiene helpers y lógica reutilizable en todo el sistema.

window.APP = (function () {

    const APP_NAME = "AcademiX";

    // --- 1. Helper: Log bonito ---
    function log(message, data = null) {
        if (data !== null) {
            console.log(`[${APP_NAME}] ${message}`, data);
        } else {
            console.log(`[${APP_NAME}] ${message}`);
        }
    }

    // --- 2. Helper: Formatear fechas (YYYY-MM-DD a DD/MM/YYYY) ---
    function formatFecha(fechaStr) {
        if (!fechaStr) return "";
        const date = new Date(fechaStr);
        if (isNaN(date.getTime())) return fechaStr;
        const d = String(date.getDate()).padStart(2, "0");
        const m = String(date.getMonth() + 1).padStart(2, "0");
        const y = date.getFullYear();
        return `${d}/${m}/${y}`;
    }

    // --- 3. Notificaciones tipo toast ---
    function ensureToastContainer() {
        let container = document.getElementById("app-toast-container");
        if (!container) {
            container = document.createElement("div");
            container.id = "app-toast-container";
            document.body.appendChild(container);
        }
        return container;
    }

    /**
     * Muestra una notificación flotante.
     * type: 'info' | 'success' | 'warning' | 'error'
     */
    function showToast(message, type = "info", timeout = 4000) {
        const container = ensureToastContainer();

        const toast = document.createElement("div");
        toast.classList.add("app-toast", `app-toast-${type}`);

        toast.innerHTML = `
            <span class="app-toast-message">${message}</span>
            <button class="app-toast-close">&times;</button>
        `;

        container.appendChild(toast);

        // Cerrar al hacer clic
        toast.querySelector(".app-toast-close").addEventListener("click", () => {
            hideToast(toast);
        });

        // Auto-cierre
        setTimeout(() => hideToast(toast), timeout);
    }

    function hideToast(toastEl) {
        if (!toastEl) return;
        toastEl.classList.add("app-toast-hide");
        setTimeout(() => {
            if (toastEl.parentNode) {
                toastEl.parentNode.removeChild(toastEl);
            }
        }, 300);
    }

    // --- 4. Confirmación genérica ---
    function confirmAction(message, callbackOk) {
        if (window.confirm(message)) {
            if (typeof callbackOk === "function") {
                callbackOk();
            }
        }
    }

    // --- 5. Sidebar: marcar opción activa según URL ---
    function marcarSidebarActiva() {
        const sidebarLinks = document.querySelectorAll(".sidebar-icon[data-href]");
        if (!sidebarLinks.length) return;

        const currentUrl = window.location.pathname;

        sidebarLinks.forEach(link => {
            const target = link.getAttribute("data-href");
            if (!target) return;

            // Si el path actual contiene el target, lo marcamos activo
            if (currentUrl.includes(target)) {
                link.classList.add("active");
            } else {
                link.classList.remove("active");
            }
        });
    }

    // --- 6. Inicialización global ---
    function init() {
        log("Iniciando scripts globales...");
        marcarSidebarActiva();
    }

    // Exponer helpers globales
    return {
        init,
        log,
        formatFecha,
        showToast,
        confirmAction
    };

})();

// Ejecutar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", function () {
    if (window.APP && typeof window.APP.init === "function") {
        window.APP.init();
    }
});
/* ===============================
   BUSCADOR EN TIEMPO REAL (TABLA)
   =============================== */
function iniciarBuscadorEnTiempoReal(selectorInput, selectorTabla) {
    const input = document.querySelector(selectorInput);
    const filas = document.querySelectorAll(selectorTabla + " tbody tr");

    if (!input || filas.length === 0) return;

    input.addEventListener("keyup", function () {
        const texto = this.value.toLowerCase().trim();

        filas.forEach(fila => {
            const contenido = fila.textContent.toLowerCase();
            fila.style.display = contenido.includes(texto) ? "" : "none";
        });
    });
}
// ===============================
//  SISTEMA DE TOASTS GLOBAL
// ===============================

function showToast(mensaje, tipo = "success") {
    const toast = document.createElement("div");

    toast.className = `custom-toast toast-${tipo}`;
    toast.innerHTML = `
        <span>${mensaje}</span>
    `;

    document.body.appendChild(toast);

    setTimeout(() => toast.classList.add("show"), 100);

    setTimeout(() => {
        toast.classList.remove("show");
        setTimeout(() => toast.remove(), 300);
    }, 3500);
}

