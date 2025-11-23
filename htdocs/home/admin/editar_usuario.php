<?php
session_start();
require_once "../../includes/conexion.php";

// Validación admin
if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol_id"] != 1) {
    header("Location: ../../index.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET["id"]);

// Obtener info del usuario
$stmt = $pdo->prepare("
    SELECT u.*, r.rol_nombre
    FROM usuarios u
    INNER JOIN cat_roles r ON r.id_rol = u.id_rol
    WHERE u.id_usuario = :id
");
$stmt->execute([":id" => $id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Usuario no encontrado.");
}

// Listas de selección
$roles = $pdo->query("SELECT * FROM cat_roles")->fetchAll(PDO::FETCH_ASSOC);
$estatus_list = $pdo->query("SELECT * FROM cat_estatus_usuario")->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar usuario - AcademiX</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- CSS ADMIN -->
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
                    <li class="px-3 small text-muted">
                        <?php echo $_SESSION["usuario_correo"]; ?>
                    </li>
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
            <a href="index.php" class="sidebar-icon active" title="Usuarios">
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
            <!--Alertas-->
            <?php include "../../includes/alertas_admin.php"; ?>
            <h3 class="mb-4 fw-bold">Editar usuario</h3>

            <div class="admin-form-card">

                <form method="POST" action="procesar_editar.php">

                    <input type="hidden" name="id" value="<?php echo $usuario["id_usuario"]; ?>">

                    <div class="mb-3">
                        <label class="form-label">Nombres</label>
                        <input type="text" name="nombres" class="form-control"
                            value="<?php echo htmlspecialchars($usuario["usuario_nombres"]); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Apellido paterno</label>
                        <input type="text" name="ap_paterno" class="form-control"
                            value="<?php echo htmlspecialchars($usuario["usuario_apellido_paterno"]); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Apellido materno</label>
                        <input type="text" name="ap_materno" class="form-control"
                            value="<?php echo htmlspecialchars($usuario["usuario_apellido_materno"]); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="correo" class="form-control"
                            value="<?php echo htmlspecialchars($usuario["usuario_correo"]); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select name="rol" class="form-select" required>
                            <?php foreach ($roles as $r): ?>
                                <option value="<?php echo $r["id_rol"]; ?>"
                                    <?php echo ($usuario["id_rol"] == $r["id_rol"]) ? "selected" : ""; ?>>
                                    <?php echo htmlspecialchars($r["rol_nombre"]); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Estatus</label>
                        <select name="estatus" class="form-select" required>
                            <?php foreach ($estatus_list as $e): ?>
                                <option value="<?php echo $e["id_estatus_usuario"]; ?>"
                                    <?php echo ($usuario["id_estatus_usuario"] == $e["id_estatus_usuario"]) ? "selected" : ""; ?>>
                                    <?php echo htmlspecialchars($e["estatus_usuario_descripcion"]); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar cambios
                        </button>
                    </div>

                </form>

            </div>

        </main>

    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
