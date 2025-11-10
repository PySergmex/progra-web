<?php
session_start();

// Validar que el usuario esté autenticado
if (!isset($_SESSION["auth"]) || $_SESSION["auth"] !== true) {
    header("Location: index.php?error=Debes iniciar sesión primero.");
    exit();
}

// Si todo está bien, redirige a la página que usa cookies
header("Location: cookie.php");
exit();
