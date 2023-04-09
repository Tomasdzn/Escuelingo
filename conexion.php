<?php
    $servidor = "localhost";
    $usuario = "root";
    $password = "";
    $base_de_datos = "escuelingo";

    // Crea la conexión
    $conn = new mysqli($servidor, $usuario, $password, $base_de_datos);

    // Verifica la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
?>
