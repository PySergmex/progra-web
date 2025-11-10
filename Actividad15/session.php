<?php
session_start();

// Verificar autenticación
if (!isset($_SESSION["auth"]) || $_SESSION["auth"] !== true) {
    header("Location: index.php?error=Debes iniciar sesión primero.");
    exit();
}

// Establecer color seleccionado
$color = $_SESSION["color"];

// Contador de visitas con sesiones
if (!isset($_SESSION["contador_sesiones"])) {
    $_SESSION["contador_sesiones"] = 1;
} else {
    $_SESSION["contador_sesiones"]++;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesiones</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
  <header>
    <nav>
      <ul class="nav nav-pills">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Actividad 15</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="http://sergioc.atwebpages.com" target="_blank" rel="noopener noreferrer">Home</a>
        </li>

        <li class="nav-item dropdown">
          <a 
            class="nav-link dropdown-toggle" 
            data-bs-toggle="dropdown" 
            href="https://github.com/PySergmex/progra-web" 
            role="button" 
            aria-expanded="false"
          >
            Github
          </a>

          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="https://github.com/PySergmex/progra-web/tree/main/Actividad3">Actividad 3</a></li>
            <li><a class="dropdown-item" href="https://github.com/PySergmex/progra-web/tree/main/Actividad4">Actividad 4</a></li>
            <li><a class="dropdown-item" href="https://github.com/PySergmex/progra-web/tree/main/Actividad5">Actividad 5</a></li>
            <li><a class="dropdown-item" href="https://github.com/PySergmex/progra-web/tree/main/Actividad6">Actividad 6</a></li>
            <li><a class="dropdown-item" href="https://github.com/PySergmex/progra-web/tree/main/Actividad7">Actividad 7</a></li>
            <li><a class="dropdown-item" href="https://github.com/PySergmex/progra-web/tree/main/Actividad8">Actividad 8</a></li>
            <li><a class="dropdown-item" href="https://github.com/PySergmex/progra-web/tree/main/Actividad10">Actividad 10</a></li>
            <li><a class="dropdown-item" href="https://github.com/PySergmex/progra-web/tree/main/Actividad11">Actividad 11</a></li>
            <li><a class="dropdown-item" href="https://github.com/PySergmex/progra-web/tree/main/Actividad12">Actividad 12</a></li>
            <li><a class="dropdown-item" href="https://github.com/PySergmex/progra-web/tree/main/Actividad13">Actividad 13</a></li>
            <li><a class="dropdown-item" href="https://github.com/PySergmex/progra-web/tree/main/Actividad14">Actividad 14</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>

<body style="color: <?= htmlspecialchars($color) ?>;">

<div class="container mt-5 text-center">

    <h2>Sesiones — Contador de visitas</h2>

    <p class="mt-3">
        Esta página cuenta cuántas veces has entrado usando <strong>$_SESSION</strong>.
    </p>

    <h3 class="mt-4">
        Visitas: <?= $_SESSION["contador_sesiones"] ?>
    </h3>

    <div class="mt-4 d-flex justify-content-center gap-3">
        <a href="home.php" class="btn btn-secondary">Regresar al Home</a>
        <a href="destroy_session.php" class="btn btn-danger">Cerrar sesión</a>
    </div>

</div>
  <footer>
    <div class="footer">
      <p>© 2025 - Todos los derechos reservados</p>
      <a href="https://github.com/PySergmex/progra-web/tree/main/Actividad15" target="_blank" rel="noopener noreferrer">
        <img src="git.png" alt="Icono de Github" width="32" height="32">
      </a>
    </div>
  </footer>

</body>
</html>
