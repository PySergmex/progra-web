<?php
session_start();

// Si ya está logueado, evitar acceso al registro
if (isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AcademiX - Registro</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tus estilos -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="vh-100">

<div class="container-fluid h-100">
    <div class="row h-100">

        <!-- PANEL IZQUIERDO -->
        <div class="col-md-6 login-left d-flex flex-column justify-content-center align-items-center text-white">
            <img src="assets/imgs/LOGO.png" class="logo-img mb-4" alt="AcademiX Logo">
        </div>

        <!-- PANEL DERECHO -->
        <div class="col-md-6 d-flex flex-column justify-content-start p-5">

            <!-- TABS -->
            <div class="w-100 d-flex justify-content-end mb-5">
                <a class="tab-btn me-2 active2">Sign Up</a>
                <a href="index.php" class="tab-btn">Sign In</a>
            </div>

            <!-- TITULO -->
            <h1 class="fw-bold">Sign Up</h1>
            <div class="underline2 mb-4"></div>

            <!-- MENSAJES -->
            <?php if (isset($_SESSION["error_signup"])): ?>
                <div class="alert alert-danger">
                    <?php 
                        echo $_SESSION["error_signup"]; 
                        unset($_SESSION["error_signup"]);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION["success_signup"])): ?>
                <div class="alert alert-success">
                    <?php 
                        echo $_SESSION["success_signup"]; 
                        unset($_SESSION["success_signup"]);
                    ?>
                </div>
            <?php endif; ?>


            <!-- FORMULARIO -->
            <div class="form-card1 p-4">
                <form action="includes/registrar_usuario.php" method="POST">

                    <label class="custom-label mt-2">Nombres</label>
                    <input type="text" name="nombres" class="form-input" required>

                    <label class="custom-label mt-4">Apellido Paterno</label>
                    <input type="text" name="apellido_paterno" class="form-input" required>

                    <label class="custom-label mt-4">Apellido Materno</label>
                    <input type="text" name="apellido_materno" class="form-input">

                    <label class="custom-label mt-4">Correo</label>
                    <input type="email" name="correo" class="form-input" required>

                    <label class="custom-label mt-4">Contraseña</label>
                    <input type="password" name="password" class="form-input" required>

                    <label class="custom-label mt-4">Confirmar Contraseña</label>
                    <input type="password" name="password2" class="form-input" required>

                    <button type="submit" class="btn submit-btn mt-4">
                        Crear Cuenta
                    </button>

                </form>
            </div>

        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<!--JS-->
    <script src="assets/js/loader.js"></script>
    <script src="assets/js/login.js"></script>
    <script src="assets/js/main.js"></script> <!-- main global -->
</body>
</html>
