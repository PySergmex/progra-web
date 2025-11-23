<?php
session_start();
require_once "../../includes/conexion.php";

/* =======================================================
   PROTEGER SOLO ADMIN
======================================================= */
if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol_id"] != 1) {
    header("Location: ../../index.php");
    exit;
}

$busqueda = $_GET["busqueda"] ?? "";
$param = "%" . $busqueda . "%";

/* =======================================================
   CONSULTA DE USUARIOS
======================================================= */
try {

    if ($busqueda !== "") {

        $sql = "
            SELECT 
                u.id_usuario,
                u.usuario_nombres,
                u.usuario_apellido_paterno,
                u.usuario_apellido_materno,
                u.usuario_correo,
                r.rol_nombre AS rol,
                e.estatus_usuario_descripcion AS estatus,
                u.usuario_fecha_creacion,
                u.usuario_fecha_actualizacion
            FROM usuarios u
            INNER JOIN cat_roles r ON u.id_rol = r.id_rol
            INNER JOIN cat_estatus_usuario e ON u.id_estatus_usuario = e.id_estatus_usuario
            WHERE u.usuario_nombres LIKE :b
               OR u.usuario_apellido_paterno LIKE :b
               OR u.usuario_correo LIKE :b
            ORDER BY u.usuario_fecha_creacion DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":b", $param);
        $stmt->execute();

    } else {

        $sql = "
            SELECT 
                u.id_usuario,
                u.usuario_nombres,
                u.usuario_apellido_paterno,
                u.usuario_apellido_materno,
                u.usuario_correo,
                r.rol_nombre AS rol,
                e.estatus_usuario_descripcion AS estatus,
                u.usuario_fecha_creacion,
                u.usuario_fecha_actualizacion
            FROM usuarios u
            INNER JOIN cat_roles r ON u.id_rol = r.id_rol
            INNER JOIN cat_estatus_usuario e ON u.id_estatus_usuario = e.id_estatus_usuario
            ORDER BY u.usuario_fecha_creacion DESC
        ";

        $stmt = $pdo->query($sql);
    }

    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error al consultar usuarios: " . $e->getMessage());
}

$nombreAdmin = $_SESSION["nombre_completo"];
$correoAdmin = $_SESSION["usuario_correo"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Usuarios - AcademiX</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- ADMIN CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>

<body class="admin-dashboard">

    <!-- TOPBAR -->
    <?php include "../../includes/topbar_admin.php"; ?>

    <!-- LAYOUT -->
    <div class="d-flex">
        <?php $pagina_activa = 'usuarios'; ?>
        <!-- SIDEBAR -->
        <?php include "../../includes/sidebar_admin.php"; ?>

        <!-- CONTENIDO -->
        <main class="content-area p-4">
            <!--Alertas-->
            <?php include "../../includes/alertas_admin.php"; ?>
            <!--Boton AgregarUsuarios-->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Usuarios del sistema</h3>

                <a href="registrar_usuario.php" class="btn btn-primary">
                    <i class="bi bi-person-plus me-1"></i> Nuevo usuario
                </a>
            </div>

            <!-- BUSCADOR -->
            <form class="row g-2 mb-3" method="get">
                <div class="col-sm-4 col-md-3">
                    <input 
                        type="text" 
                        name="busqueda" 
                        class="form-control"
                        placeholder="Buscar por nombre o correo"
                        value="<?php echo htmlspecialchars($busqueda); ?>"
                    >
                </div>
                <div class="col-sm-3 col-md-2">
                    <button class="btn btn-outline-secondary w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>

                <?php if ($busqueda !== ""): ?>
                <div class="col-sm-3 col-md-2">
                    <a href="index.php" class="btn btn-link text-decoration-none">Limpiar filtro</a>
                </div>
                <?php endif; ?>
            </form>

            <!-- TABLA -->
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre completo</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Estatus</th>
                                <th>Creado</th>
                                <th>Actualizado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (empty($usuarios)): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No se encontraron usuarios.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($usuarios as $u): ?>
                                <tr>
                                    <td><?php echo $u["id_usuario"]; ?></td>

                                    <td><?php echo htmlspecialchars($u["usuario_nombres"] . " " . $u["usuario_apellido_paterno"] . " " . $u["usuario_apellido_materno"]); ?></td>

                                    <td><?php echo htmlspecialchars($u["usuario_correo"]); ?></td>

                                    <td><?php echo htmlspecialchars($u["rol"]); ?></td>

                                    <td><?php echo htmlspecialchars($u["estatus"]); ?></td>

                                    <td><?php echo $u["usuario_fecha_creacion"]; ?></td>

                                    <td><?php echo $u["usuario_fecha_actualizacion"]; ?></td>

                                    <td class="text-center">
                                        <a href="ver_usuario.php?id=<?php echo $u['id_usuario']; ?>"
                                           class="btn btn-sm btn-outline-info me-1">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="editar_usuario.php?id=<?php echo $u['id_usuario']; ?>"
                                           class="btn btn-sm btn-outline-warning me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="eliminar_usuario.php?id=<?php echo $u['id_usuario']; ?>"
                                           onclick="return confirm('¿Seguro que deseas eliminar este usuario?');"
                                           class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- TU SCRIPT GENERAL -->
<script src="../../assets/js/main.js"></script>

<!-- BUSCADOR EN TIEMPO REAL -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    iniciarBuscadorEnTiempoReal(
        "input[name='busqueda']",
        "table"
    );
});
</script>

</body>
</html>
