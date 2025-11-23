<?php
session_start();
require_once "../../includes/conexion.php";

// =========================================
// 1) Validación admin
// =========================================
if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol_id"] != 1) {
    header("Location: ../../index.php");
    exit;
}

// =========================================
// 2) Validación básica
// =========================================
if (!isset($_POST["id"])) {
    header("Location: index.php?error=sin_id");
    exit;
}

$id         = intval($_POST["id"]);
$nombres    = trim($_POST["nombres"]);
$ap_paterno = trim($_POST["ap_paterno"]);
$ap_materno = trim($_POST["ap_materno"]);
$correo     = trim($_POST["correo"]);
$rol        = intval($_POST["rol"]);
$estatus    = intval($_POST["estatus"]);

// =========================================
// 3) Verificar existencia del usuario
// =========================================
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = :id LIMIT 1");
$stmt->execute([":id" => $id]);
$usuarioActual = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuarioActual) {
    header("Location: index.php?error=usuario_no_encontrado");
    exit;
}

// =========================================
// 4) Validar correo duplicado (excepto su mismo ID)
// =========================================
$stmt = $pdo->prepare("
    SELECT id_usuario 
    FROM usuarios 
    WHERE usuario_correo = :correo 
      AND id_usuario != :id
    LIMIT 1
");
$stmt->execute([
    ":correo" => $correo,
    ":id" => $id
]);

if ($stmt->rowCount() > 0) {
    header("Location: editar_usuario.php?id=$id&error=correo_duplicado");
    exit;
}

// =========================================
// 5) Actualizar usuario
// =========================================
$stmt = $pdo->prepare("
    UPDATE usuarios
    SET usuario_nombres         = :n,
        usuario_apellido_paterno = :p,
        usuario_apellido_materno = :m,
        usuario_correo           = :c,
        id_rol                   = :r,
        id_estatus_usuario       = :e,
        usuario_fecha_actualizacion = NOW()
    WHERE id_usuario = :id
");

$stmt->execute([
    ":n"  => $nombres,
    ":p"  => $ap_paterno,
    ":m"  => $ap_materno,
    ":c"  => $correo,
    ":r"  => $rol,
    ":e"  => $estatus,
    ":id" => $id
]);

// =========================================
// 6) Redirigir al listado con mensaje
// =========================================
header("Location: index.php?edit=ok");
exit;

?>
