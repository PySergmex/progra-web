<?php
session_start();
require_once "../../includes/conexion.php";

// Validación admin
if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol_id"] != 1) {
    header("Location: ../../index.php");
    exit;
}

$nombres = trim($_POST["nombres"]);
$ap_paterno = trim($_POST["ap_paterno"]);
$ap_materno = trim($_POST["ap_materno"]);
$correo = trim($_POST["correo"]);
$password = trim($_POST["password"]);
$rol = intval($_POST["rol"]);
$estatus = intval($_POST["estatus"]);

// Verificar correo duplicado
$stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE usuario_correo = :correo LIMIT 1");
$stmt->execute([":correo" => $correo]);

if ($stmt->rowCount() > 0) {
    header("Location: registrar_usuario.php?error=correo_duplicado");
    exit;
}

// Insertar usuario
$stmt = $pdo->prepare("
    INSERT INTO usuarios 
    (usuario_nombres, usuario_apellido_paterno, usuario_apellido_materno, usuario_correo, usuario_password, id_rol, id_estatus_usuario) 
    VALUES (:n, :p, :m, :c, :pass, :r, :e)
");

$stmt->execute([
    ":n" => $nombres,
    ":p" => $ap_paterno,
    ":m" => $ap_materno,
    ":c" => $correo,
    ":pass" => password_hash($password, PASSWORD_DEFAULT),
    ":r" => $rol,
    ":e" => $estatus
]);

header("Location: index.php?registro=ok");
exit;
