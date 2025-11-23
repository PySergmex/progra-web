<?php
session_start();
require_once "../../includes/conexion.php";

// SOLO ADMIN
if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol_id"] != 1) {
    header("Location: ../../index.php");
    exit;
}

$idAdmin = (int)$_SESSION["id_usuario"];
$id      = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

if ($id <= 0) {
    $_SESSION["admin_error"] = "ID de usuario no válido.";
    header("Location: index.php");
    exit;
}

// Evitar que un admin se borre a sí mismo (opcional pero recomendado)
if ($id === $idAdmin) {
    $_SESSION["admin_error"] = "No puedes eliminar tu propio usuario.";
    header("Location: index.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = :id");
    $stmt->execute([":id" => $id]);

    if ($stmt->rowCount() > 0) {
        $_SESSION["admin_success"] = "Usuario eliminado correctamente.";
    } else {
        $_SESSION["admin_error"] = "No se encontró el usuario a eliminar.";
    }

} catch (PDOException $e) {
    $_SESSION["admin_error"] = "Error al eliminar: " . $e->getMessage();
}

header("Location: index.php");
exit;
