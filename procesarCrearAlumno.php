<?php
require_once "conexion.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'insertAlumno') {
    insertAlumno();
}

function insertAlumno() {
    global $conn;
    $id = $_SESSION['id'];

    $al_name = $_POST['al_name'];
    $al_apellido = $_POST['al_apellido'];
    $al_correo = $_POST['al_correo'];
    $al_fecha = $_POST['al_fecha'];
    $al_numero = $_POST['al_numero'];
    $al_estado = $_POST['al_estado'];
    $al_clase = $_POST['al_clase'];

    // Ver si la clase ya existe
    $result = mysqli_query($conn, "SELECT * FROM alumno WHERE nombre = '$al_name' 
    AND apellido = '$al_apellido' 
    AND correo = '$al_correo' 
    AND fechanac = '$al_fecha' 
    AND telefono = '$al_numero' 
    AND estado = '$al_estado' 
    AND clase_idclase = '$al_clase';");

    if (mysqli_num_rows($result) > 0) {
        echo 2;
        return;
    } else {
        // Insertar clase
        $sql = "INSERT INTO alumno (nombre, apellido, correo, fechanac, telefono, estado, clase_idclase) 
        VALUES ('$al_name','$al_apellido','$al_correo','$al_fecha','$al_numero','$al_estado','$al_clase');";
        mysqli_query($conn, $sql);
        $sql_clase = "UPDATE clase SET alumnos = alumnos + 1 WHERE idclase = '$al_clase'";
        mysqli_query($conn, $sql_clase);
        echo 1;
        return;
    }
}
?>