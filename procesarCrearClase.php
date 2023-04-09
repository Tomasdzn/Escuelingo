<?php
require_once "conexion.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'insertClase') {
    insertClase();
}

function getIdMateria($name, $conn){
    // Recuperar las variables de sesión
    $id = $_SESSION['id'];

    // Realizar una consulta en la base de datos
    $sql = "SELECT idmateria FROM materia WHERE nombre = '$name';";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row["idmateria"];
        }
    } else {
        return null;
    }
}

function insertClase() {
    global $conn;
    $id = $_SESSION['id'];
    
    $materia = $_POST['materia'];
    $curso = $_POST['curso'];
    $letra = $_POST['letra'];
    $idmateria = getIdMateria($materia, $conn);

    // Ver si la clase ya existe
    $result = mysqli_query($conn, "SELECT * FROM clase WHERE curso = '$curso' AND letra = '$letra' AND materia_idmateria = '$idmateria';");
    if (mysqli_num_rows($result) > 0) {
        echo 2;
        return;
    } else {
        // Insertar clase
        $sql = "INSERT INTO clase (curso, letra, usuario_idusuario, materia_idmateria) 
        VALUES ('$curso','$letra', '$id','$idmateria');";
        mysqli_query($conn, $sql);
        echo 1;
        return;
    }
}
?>