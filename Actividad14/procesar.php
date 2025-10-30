<?php

$num1 = $_GET['num1'];
$num2 = $_GET['num2'];
$op = $_GET['operacion'];
$resultado = 0;
    switch ($op) {
        case "suma":
            $resultado = $num1 + $num2;
            break;

        case "resta":
            $resultado = $num1 - $num2;
            break;

        case "mul":
            $resultado = $num1 * $num2;
            break;

        case "div":
            if ($num2 != 0) {
                $resultado = $num1 / $num2;
            } else {
                echo "No se puede dividir entre cero.";
                exit;
            }
            break;

        default:
            echo "La operación no está disponible.";
            exit;
    }


    ?>
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3>Resultado de la Operación</h3>
            </div>
            <div class="card-body text-center">
                <h4><strong>Número 1:</strong> <?= $num1 ?></h4>
                <h4><strong>Número 2:</strong> <?= $num2 ?></h4>
                <hr>
                <h3 class="text-success"><strong>Resultado:</strong> <?= $resultado ?></h3>
                <hr>
                <a href="form.php" class="btn btn-outline-primary mt-3">Volver</a>
            </div>
        </div>
    </div>
</body>
</html>