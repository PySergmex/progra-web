<?php
/**
 * Archivo — Destruye la cookie del contador
 */

// Para eliminar una cookie: la definimos con fecha expirada
setcookie("contador_cookies", "", time() - 3600);

// Regresar a la página de cookies
header("Location: cookie.php");
exit();
