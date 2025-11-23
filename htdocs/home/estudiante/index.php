<?php
session_start();
require_once "../../includes/conexion.php";

// Proteger ruta
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../../index.php");
    exit;
}

if ($_SESSION["rol_id"] != 3) {
    header("Location: ../../index.php");
    exit;
}

$idUsuario = $_SESSION["id_usuario"];
$nombre    = $_SESSION["nombre_completo"] ?? '';
$correo    = $_SESSION["usuario_correo"] ?? '';

// HORARIOS DE MATERIAS (las que tenga aprobadas)
$stmtHorarios = $pdo->prepare("
    SELECT m.materia_nombre, m.materia_horario
    FROM inscripciones i
    INNER JOIN materias m ON m.id_materia = i.id_materia
    WHERE i.id_usuario_estudiante = :id
      AND i.id_estatus_inscripcion = 2
    ORDER BY m.materia_nombre
    LIMIT 5
");
$stmtHorarios->execute([":id" => $idUsuario]);
$horarios = $stmtHorarios->fetchAll(PDO::FETCH_ASSOC);

// CONTADORES: MATERIAS PENDIENTES vs APROBADAS
$stmtEstatus = $pdo->prepare("
    SELECT
        SUM(CASE WHEN id_estatus_inscripcion = 1 THEN 1 ELSE 0 END) AS pendientes,
        SUM(CASE WHEN id_estatus_inscripcion = 2 THEN 1 ELSE 0 END) AS aprobadas
    FROM inscripciones
    WHERE id_usuario_estudiante = :id
");
$stmtEstatus->execute([":id" => $idUsuario]);
$estatusMaterias = $stmtEstatus->fetch(PDO::FETCH_ASSOC);

$materiasPendientes = $estatusMaterias["pendientes"] ?? 0;
$materiasAprobadas  = $estatusMaterias["aprobadas"] ?? 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Estudiante - AcademiX</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos (Bootstrap Icons) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Estilos generales + dashboard -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/estudiante.css">
</head>
<body class="vh-100">

    <!-- LOADER -->
    <div id="loader-overlay" class="loader-overlay d-none">
        <img src="../../assets/imgs/LOGO.png" class="loader-logo" alt="AcademiX Logo">
        <h4 class="mt-3 text-white">Cargando...</h4>
    </div>

    <div class="dashboard-estudiante h-100 d-flex flex-column">

        <!-- TOPBAR -->
        <header class="topbar d-flex align-items-center justify-content-between px-4">
            <div class="d-flex align-items-center">
                <img src="../../assets/imgs/LOGO-NAV.png" alt="AcademiX Logo" class="logo-dashboard me-2">
            </div>

            <div class="d-flex align-items-center gap-3">
                <span class="bienvenido-text">
                    Bienvenido <?php echo htmlspecialchars($nombre); ?>
                </span>

                <!-- Menú de usuario -->
                <div class="dropdown user-menu">
                    <button class="btn btn-user-avatar dropdown-toggle p-0" type="button"
                            id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            <img src="../../assets/imgs/USER.png" alt="Usuario">
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end user-dropdown" aria-labelledby="dropdownUser">
                        <li class="px-3 pt-2 pb-1 small text-muted">
                            <?php echo htmlspecialchars($correo); ?>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="../../logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- CONTENEDOR PRINCIPAL -->
        <div class="flex-grow-1 d-flex">

            <!-- SIDEBAR SOLO ÍCONOS -->
            <aside class="sidebar d-flex flex-column align-items-center pt-4">
                <a href="index.php" class="sidebar-icon active" data-href="home/estudiante/index.php" title="Inicio">
                    <i class="bi bi-house-door"></i>
                </a>
                <a href="materias.php" class="sidebar-icon" data-href="materias.php" title="Mis materias">
                    <i class="bi bi-journal-bookmark"></i>
                </a>
                <a href="calificaciones.php" class="sidebar-icon" data-href="calificaciones.php" title="Calificaciones">
                    <i class="bi bi-bar-chart-line"></i>
                </a>
                <a href="tareas.php" class="sidebar-icon" data-href="tareas.php" title="Tareas">
                    <i class="bi bi-card-checklist"></i>
                </a>
                <a href="mensajes.php" class="sidebar-icon" data-href="mensajes.php" title="Mensajes">
                    <i class="bi bi-chat-dots"></i>
                </a>
                <a href="perfil.php" class="sidebar-icon" data-href="perfil.php" title="Perfil">
                    <i class="bi bi-person-circle"></i>
                </a>

            </aside>

        
            <!--Contenido Principal-->
            <main class="content-area p-4">

                <div class="dashboard-wrapper">

                    <!-- (1) GRÁFICA DE BARRAS - OCUPA TODA LA FILA -->
                    <div class="grid-bar">
                        <div class="card chart-card chart-card-large mb-4 animate-fade-up animate-delay-1">
                            <div class="card-header border-0 bg-transparent">
                                <h5 class="mb-0">Promedio por materia</h5>
                                <small class="text-muted">Basado en las tareas calificadas</small>
                            </div>

                            <div class="card-body">
                                <canvas id="graficaPromedio"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- (2.1) COLUMNA IZQUIERDA — RESUMEN -->
                    <div class="grid-resumen">
                        <div class="card resumen-card animate-fade-up animate-delay-2">
                            <h5>Mis materias</h5>
                            <p>Materias inscritas actualmente.</p>
                            <span class="resumen-number"><?php echo $totalMaterias ?? 5; ?></span>
                        </div>

                        <div class="card resumen-card animate-fade-up animate-delay-3">
                            <h5>Tareas pendientes</h5>
                            <p>Tareas próximas a entregar.</p>
                            <span class="resumen-number"><?php echo $tareasPendientes ?? 3; ?></span>
                        </div>

                        <div class="card resumen-card animate-fade-up animate-delay-4">
                            <h5>Promedio general</h5>
                            <p>Promedio del ciclo actual.</p>
                            <span class="resumen-number"><?php echo $promedioGeneral ?? 9.2; ?></span>
                        </div>
                    </div>

                    <!-- (2.2) COLUMNA CENTRAL — GRÁFICA DONUT -->
                    <div class="grid-donut">
                        <div class="card chart-card h-100 animate-fade-up animate-delay-3 w-100">
                            <div class="card-header border-0 bg-transparent">
                                <h5 class="mb-0">Tareas de esta semana</h5>
                                <small class="text-muted">Completadas vs pendientes</small>
                            </div>
                            <div class="card-body">
                                <canvas id="graficaTareas"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- (2.3) COLUMNA DERECHA — HORARIOS -->
                    <div class="grid-horarios">
                        <div class="card horarios-card animate-fade-up animate-delay-3">
                            <div class="card-header border-0 bg-transparent">
                                <h5 class="mb-0">Horarios de mis materias</h5>
                                <small class="text-muted">Próximas clases</small>
                            </div>

                            <div class="card-body p-3">
                                <?php if (!empty($horarios)): ?>
                                    <ul class="list-unstyled mb-0">
                                        <?php foreach ($horarios as $h): ?>
                                            <li class="horario-item">
                                                <span><?php echo htmlspecialchars($h["materia_nombre"]); ?></span>
                                                <span class="text-muted small">
                                                    <?php echo htmlspecialchars($h["materia_horario"]); ?>
                                                </span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="text-muted small">No tienes clases próximas.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- (3) FILA COMPLETA — ESTADO MATERIAS -->
                    <div class="grid-status">
                        <div class="card materias-status-card animate-fade-up animate-delay-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Materias aprobadas</h6>
                                    <span class="status-number aprobado">
                                        <?php echo (int)$materiasAprobadas; ?>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-1">Materias pendientes por aprobar</h6>
                                    <span class="status-number pendiente">
                                        <?php echo (int)$materiasPendientes; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- /dashboard-wrapper -->

            </main>



        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="../../assets/js/loader.js"></script>
    <script src="../../assets/js/main.js"></script>
    <script src="../../assets/js/dashboard_estudiante.js"></script>
    <script src="../../assets/js/theme.js"></script>

</body>
</html>
