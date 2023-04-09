<?php
require_once "conexion.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'modificarAlumno') {
    modificarAlumno();
}

function modificarAlumno() {
    global $conn;
    $al_name = $_POST['al_name'];
    $al_apellido = $_POST['al_apellido'];
    $al_correo = $_POST['al_correo'];
    $al_fecha = $_POST['al_fecha'];
    $al_numero = $_POST['al_numero'];
    $al_estado = $_POST['al_estado'];
    $al_clase = $_POST['al_clase'];
    $al_id = $_POST['al_id'];

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
        $sql = "UPDATE alumno 
        SET nombre = '$al_name', apellido = '$al_apellido' , correo = '$al_correo', fechanac = '$al_fecha', 
        telefono = '$al_numero', estado = '$al_estado', clase_idclase = '$al_clase'
        WHERE idalumno = '$al_id';";
        mysqli_query($conn, $sql);
        echo 1;
        return;
    }
}
?>