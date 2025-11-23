<?php
    // Incluimos la conexión
    require_once 'conexion.php';

    try {
        // Ejecutamos una consulta básica para verificar la conexión
        $stmt = $pdo->query("SELECT 1");
        $resultado = $stmt->fetch();

        echo "<h2>✅ Conexión exitosa a la base de datos 'academix'</h2>";
        echo "<p>Consulta de prueba ejecutada correctamente.</p>";

    } catch (PDOException $e) {
        echo "<h2>❌ Error ejecutando la consulta de prueba</h2>";
        echo "<p>" . $e->getMessage() . "</p>";
    }
?>
