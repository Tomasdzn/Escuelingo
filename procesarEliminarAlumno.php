<?php
    require_once "conexion.php";

    // Obtener el ID de la fila a eliminar
    $idalumno = $_POST['idalumno'];
    $clase = $_POST['clase'];

    $datos_clase = str_split($clase);
    $letra_clase = $datos_clase[1];
    $curso_clase = $datos_clase[0];

    // Eliminar la fila correspondiente de la base de datos
    $sql = "DELETE FROM alumno WHERE idalumno = '$idalumno'";
    if ($conn->query($sql) === TRUE) {
        $al_clase = getClase($conn, $curso_clase, $letra_clase);
        if($al_clase != null){
            $sql_clase = "UPDATE clase SET alumnos = alumnos - 1 WHERE idclase = '$al_clase'";
            if (mysqli_query($conn, $sql_clase) === TRUE) {
                echo 'success';
            } else {
                echo 'error';
            }
        }else{
            echo 'error';
        }
    } else {
        // Si la eliminación no se realiza correctamente, devolver un mensaje de error al cliente
        echo 'error';
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

    function getClase($conn, $curso_clase, $letra_clase){

        // Realizar una consulta en la base de datos
        $sql = "SELECT idclase FROM clase WHERE curso = '$curso_clase' AND letra = '$letra_clase'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row["idclase"];
            }
        } else {
            return null;
        }
    }
?>
