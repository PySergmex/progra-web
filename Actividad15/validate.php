<?php
session_start();

// Validación por campos vacíos
if (empty($_POST["user"]) || empty($_POST["password"]) || empty($_POST["color"])) {
    header("Location: index.php?error=Por favor completa todos los campos.");
    exit();
}

// Guardar datos
$user = $_POST["user"];
$password = $_POST["password"];
$color = $_POST["color"];

// Credenciales fijas
$usuario_valido = "user";
$password_valida = "admin123";

// Validación de credenciales
if ($user !== $usuario_valido || $password !== $password_valida) {
    header("Location: index.php?error=Credenciales incorrectas.");
    exit();
}

// Guardar sesión
$_SESSION["auth"] = true;
$_SESSION["color"] = $color;

// Redirigir al home
header("Location: home.php");
exit();
