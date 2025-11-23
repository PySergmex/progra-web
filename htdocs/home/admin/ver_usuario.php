<?php
session_start();
require_once "../../includes/conexion.php";

// Validar admin
if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol_id"] != 1) {
    header("Location: ../../index.php");
    exit;
}

// Validar usuario a mostrar
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET["id"]);

// Obtener información del usuario
$stmt = $pdo->prepare("
    SELECT 
        u.*,
        r.rol_nombre,
        e.estatus_usuario_descripcion AS estatus
    FROM usuarios u
    INNER JOIN cat_roles r ON r.id_rol = u.id_rol
    INNER JOIN cat_estatus_usuario e ON e.id_estatus_usuario = u.id_estatus_usuario
    WHERE u.id_usuario = :id
");
$stmt->execute([":id" => $id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Usuario no encontrado.");
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil del usuario - AcademiX</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- CSS Admin -->
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>

<body class="admin-dashboard">

    <!-- TOPBAR -->
    <header class="topbar">
        <img src="../../assets/imgs/LOGO-NAV.png" class="logo-dashboard">

        <div class="d-flex align-items-center gap-3">
            <span class="bienvenido-text">
                Administrador: <?php echo $_SESSION["nombre_completo"]; ?>
            </span>

            <div class="dropdown">
                <button class="btn btn-user-avatar p-0 dropdown-toggle" data-bs-toggle="dropdown">
                    <div class="user-avatar">
                        <img src="../../assets/imgs/USER.png">
                    </div>
                </button>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="px-3 small text-muted"><?php echo $_SESSION["usuario_correo"]; ?></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a href="../../logout.php" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- LAYOUT -->
    <div class="d-flex">

        <!-- SIDEBAR -->
        <aside class="sidebar-admin">
            <a href="index.php" class="sidebar-icon" title="Usuarios">
                <i class="bi bi-people"></i>
            </a>

            <a href="../index.php" class="sidebar-icon" title="Dashboard">
                <i class="bi bi-speedometer2"></i>
            </a>

            <a href="../materias/index.php" class="sidebar-icon" title="Materias">
                <i class="bi bi-journal-bookmark"></i>
            </a>
        </aside>

        <!-- CONTENIDO -->
        <main class="content-area">

            <h3 class="mb-4 fw-bold">Perfil del usuario</h3>

            <!-- TARJETA DE PERFIL -->
            <div class="admin-form-card p-4 col-lg-6 col-md-8 col-sm-12">

                <div class="mb-3">
                    <label class="form-label text-muted">Nombre completo</label>
                    <div class="fw-bold fs-5">
                        <?php echo htmlspecialchars(
                            $usuario["usuario_nombres"] . " " .
                            $usuario["usuario_apellido_paterno"] . " " .
                            $usuario["usuario_apellido_materno"]
                        ); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Correo electrónico</label>
                    <div class="fw-semibold">
                        <?php echo htmlspecialchars($usuario["usuario_correo"]); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Rol</label>
                    <div class="fw-semibold">
                        <?php echo htmlspecialchars($usuario["rol_nombre"]); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Estatus</label>
                    <div class="fw-semibold">
                        <?php echo htmlspecialchars($usuario["estatus"]); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Fecha de creación</label>
                    <div class="fw-semibold">
                        <?php echo htmlspecialchars($usuario["usuario_fecha_creacion"]); ?>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted">Última actualización</label>
                    <div class="fw-semibold">
                        <?php echo htmlspecialchars($usuario["usuario_fecha_actualizacion"]); ?>
                    </div>
                </div>

                <!-- BOTONES -->
                <div class="d-flex justify-content-between">

                    <a href="index.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>

                    <a href="editar_usuario.php?id=<?php echo $usuario["id_usuario"]; ?>"
                       class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Editar usuario
                    </a>

                </div>

            </div>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
