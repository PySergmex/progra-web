<?php
/**
 * Archivo 03 — Destruir variable de sesión
 */

session_start();
session_unset();  
session_destroy();

// Redirigir al login
header("Location: index.php");
exit();
