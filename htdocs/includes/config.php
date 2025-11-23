<?php
/**
 * CONFIGURACIÓN GLOBAL DE ACADEMIX
 * Detecta automáticamente la URL base del proyecto.
 */

if (!isset($_SESSION)) {
    session_start();
}

/* -------------------------------------------------------------
   AUTO-DETECCIÓN DE BASE_URL
------------------------------------------------------------- */

// Detectar si usamos HTTPS
$es_https = (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
    $_SERVER['SERVER_PORT'] == 443
);

$protocolo = $es_https ? "https://" : "http://";

// Dominio (localhost o hosting real)
$dominio = $_SERVER["HTTP_HOST"];

// Ruta interna del proyecto (subcarpetas incluidas)
$ruta = rtrim(dirname($_SERVER["SCRIPT_NAME"]), "/\\") . "/";

// BASE_URL final (si el proyecto está en /proyecto/, queda así)
define("BASE_URL", $protocolo . $dominio . $ruta);

?>
