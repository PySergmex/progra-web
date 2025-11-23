<?php
    $host = 'localhost';              // Dirección del servidor donde está MySQL (aquí, tu propia computadora)
    $dbname = 'academix';             // Nombre de la base de datos a la que te quieres conectar
    $usuario = 'root';                // Usuario de MySQL (por defecto, “root” en local)
    $clave = 'Server02.';                  // Contraseña del usuario de MySQL
    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $usuario,
            $clave
        );
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        //Evita errores raros con parámetros
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
?>
