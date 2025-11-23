<?php
session_start();

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id_usuario = intval($_GET["id"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

<div class="card p-4" style="width: 350px;">
    <h4 class="text-center mb-3">Restablecer contraseña</h4>

    <?php if (isset($_SESSION["error_reset"])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION["error_reset"]; unset($_SESSION["error_reset"]); ?>
        </div>
    <?php endif; ?>

    <form action="includes/procesar_restablecer.php" method="POST">
        <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">

        <label class="form-label">Nueva contraseña</label>
        <input type="password" name="password" class="form-control" required>

        <label class="form-label mt-3">Confirmar contraseña</label>
        <input type="password" name="password2" class="form-control" required>

        <button class="btn btn-dark w-100 mt-4">Guardar nueva contraseña</button>
    </form>
</div>
</body>
</html>
