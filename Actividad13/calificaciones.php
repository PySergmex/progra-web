<?php
// Constantes 
define("num_a", 5);

// Array de nombres
$nombres = ["Isaac", "Sergio", "Luis", "Pedro", "Juan"];

// Array de calificaciones
$calificaciones = [];

// Generar calificaciones aleatorias
for ($i = 0; $i < num_a; $i++) {
    $calificaciones[$i] = rand(50, 100);
}

// Función para calcular promedio
function calcularPromedio($calificaciones) {
    $suma = array_sum($calificaciones);
    return $suma / count($calificaciones);
}

// Encabezado
echo "<h3 class='text-center mt-4 mb-3'>Listado de Estudiantes y Calificaciones</h3>";

// Tabla Bootstrap
echo '<div class="container">';
echo '<table class="table table-striped table-bordered text-center align-middle">';
echo '<thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Calificación</th>
            <th>Estado</th>
        </tr>
      </thead>';
echo '<tbody>';

// Llenado de filas
for ($i = 0; $i < num_a; $i++) {
    $estado = ($calificaciones[$i] >= 60) ? "Aprobado" : "Reprobado";
    $clase_estado = ($calificaciones[$i] >= 60) ? "text-success fw-bold" : "text-danger fw-bold";

    echo "<tr>
            <td>" . ($i + 1) . "</td>
            <td>" . $nombres[$i] . "</td>
            <td>" . $calificaciones[$i] . "</td>
            <td class='$clase_estado'>" . $estado . "</td>
          </tr>";
}

echo '</tbody>';
echo '</table>';

// Promedio
$promedio = calcularPromedio($calificaciones);
$color_promedio = ($promedio >= 60) ? "text-success" : "text-danger";
echo "<h4 class='text-center mt-4'>Promedio general del grupo: 
        <span class='$color_promedio'>" . number_format($promedio, 2) . "</span>
      </h4>";
echo '</div>';
?>
