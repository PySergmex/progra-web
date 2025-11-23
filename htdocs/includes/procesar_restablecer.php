<?php
session_start();
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

$id_usuario = intval($_POST["id_usuario"]);
$password = trim($_POST["password"]);
$password2 = trim($_POST["password2"]);

// Contraseñas iguales
if ($password !== $password2) {
    $_SESSION["error_reset"] = "Las contraseñas no coinciden.";
    header("Location: ../restablecer.php?id=" . $id_usuario);
    exit;
}

// Longitud mínima
if (strlen($password) < 6) {
    $_SESSION["error_reset"] = "La contraseña debe tener al menos 6 caracteres.";
    header("Location: ../restablecer.php?id=" . $id_usuario);
    exit;
}

// Debe incluir número
if (!preg_match('/[0-9]/', $password)) {
    $_SESSION["error_reset"] = "La contraseña debe incluir al menos un número.";
    header("Location: ../restablecer.php?id=" . $id_usuario);
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $sql = "UPDATE usuarios SET usuario_password = :pass WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":pass", $hash);
    $stmt->bindParam(":id", $id_usuario);
    $stmt->execute();

    $_SESSION["success_reset"] = "Contraseña actualizada. ¡Ya puedes iniciar sesión!";
    header("Location: ../index.php");
    exit;

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
