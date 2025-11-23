<?php
session_start();
require_once "conexion.php"; 

// Verificar que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$correo = trim($_POST["correo"]);
$password = trim($_POST["password"]);

try {
    // Consulta preparada
    $sql = "SELECT 
                id_usuario,
                usuario_nombres,
                usuario_apellido_paterno,
                usuario_apellido_materno,
                usuario_correo,
                usuario_password,
                id_rol
            FROM usuarios
            WHERE usuario_correo = :correo
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
    $stmt->execute();

    // Validar usuario 
    if ($stmt->rowCount() === 0) {
        $_SESSION["error_login"] = "Correo o contraseña incorrectos.";
        header("Location: ../index.php");
        exit;
    }

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validar contraseña
    if (!password_verify($password, $usuario["usuario_password"])) {
        $_SESSION["error_login"] = "Correo o contraseña incorrectos.";
        header("Location: ../index.php");
        exit;
    }

    // INICIO DE SESIÓN EXITOSO
    $_SESSION["id_usuario"] = $usuario["id_usuario"];
    $_SESSION["nombre_completo"] = 
        $usuario["usuario_nombres"] . " " . 
        $usuario["usuario_apellido_paterno"] . " " . 
        $usuario["usuario_apellido_materno"];

    $_SESSION["rol_id"] = $usuario["id_rol"];
    $_SESSION["usuario_correo"] = $usuario["usuario_correo"];


    // Redirigir según rol
    switch ($usuario["id_rol"]) {
        case 1:
            header("Location: ../home/admin/index.php");
            break;

        case 2:
            header("Location: ../home/profesor/index.php");
            break;

        case 3:
            header("Location: ../home/estudiante/index.php");
            break;

        default:
            header("Location: ../home/estudiante/index.php");
}


    exit;

} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>

