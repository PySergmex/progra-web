<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Calificaciones</title>

  <!-- Descripción para SEO -->
  <meta name="description" content="Sistema de calificaciones desarrollado en PHP con integración de Bootstrap.">

  <!-- CSS Bootstrap -->
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
    rel="stylesheet"
  >

  <!-- Hoja de estilos -->
  <link rel="stylesheet" href="style.css?v=1.0">
</head>

<body>
  <header>
    <nav>
      <ul class="nav nav-pills">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Actividad 13</a>
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
          </ul>
        </li>
      </ul>
    </nav>
  </header>

  <main>
    <?php include('calificaciones.php'); ?>
  </main>

  <footer>
    <div class="footer">
      <p>© 2025 - Todos los derechos reservados</p>
      <a href="#" target="_blank" rel="noopener noreferrer">
        <img src="git.png" alt="Icono de Github" width="32" height="32">
      </a>
    </div>
  </footer>

  <!-- JS Bootstrap -->
  <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
    crossorigin="anonymous">
  </script>
</body>
</html>
