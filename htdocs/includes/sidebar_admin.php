<?php
if (!isset($pagina_activa)) {
    $pagina_activa = '';
}
require_once __DIR__ . "/config.php";
?>

<aside class="sidebar-admin d-flex flex-column align-items-center pt-4">

    <!-- USUARIOS -->
    <a href="<?= BASE_URL ?>home/admin/index.php"
       class="sidebar-icon <?= ($pagina_activa == 'usuarios') ? 'active' : ''; ?>"
       title="Usuarios">
        <i class="bi bi-people"></i>
    </a>

    <!-- MAESTROS -->
    <a href="<?= BASE_URL ?>home/admin/maestros/index.php"
       class="sidebar-icon <?= ($pagina_activa == 'maestros') ? 'active' : ''; ?>"
       title="Maestros">
        <i class="bi bi-person-workspace"></i>
    </a>

    <!-- DASHBOARD -->
    <a href="<?= BASE_URL ?>home/admin/dashboard.php"
       class="sidebar-icon <?= ($pagina_activa == 'dashboard') ? 'active' : ''; ?>"
       title="Dashboard">
        <i class="bi bi-speedometer2"></i>
    </a>

    <!-- MATERIAS -->
    <a href="<?= BASE_URL ?>home/admin/materias/index.php"
       class="sidebar-icon <?= ($pagina_activa == 'materias') ? 'active' : ''; ?>"
       title="Materias">
        <i class="bi bi-journal-bookmark"></i>
    </a>

</aside>

