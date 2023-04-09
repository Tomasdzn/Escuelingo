<?php

    require_once "conexion.php";

    // Obtener el ID de la fila a eliminar
    $idclase = $_POST['idclase'];

    // Eliminar la fila correspondiente de la base de datos
    $sql = "DELETE FROM clase WHERE idclase = '$idclase'";
    if ($conn->query($sql) === TRUE) {
        // Si la eliminación se realiza correctamente, devolver una respuesta de éxito al cliente
        echo 'success';
    } else {
        // Si la eliminación no se realiza correctamente, devolver un mensaje de error al cliente
        echo 'error';
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

?>
