<?php
session_start();
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: recuperar.php");
    exit;
}

$correo = trim($_POST["correo"]);

try {
    $sql = "SELECT id_usuario FROM usuarios WHERE usuario_correo = :correo LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":correo", $correo);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        $_SESSION["error_recuperar"] = "El correo no está registrado.";
        header("Location: ../recuperar.php");
        exit;
    }

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Ir al formulario de nueva contraseña
    header("Location: ../restablecer.php?id=" . $usuario["id_usuario"]);
    exit;

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
