<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION["auth"]) || $_SESSION["auth"] !== true) {
    header("Location: index.php?error=Debes iniciar sesión primero.");
    exit();
}

// Si está autenticado, redirigir a la página que muestra el contador
header("Location: session.php");
exit();
