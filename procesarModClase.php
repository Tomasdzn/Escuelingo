<?php
require_once "conexion.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'modificarClase') {
    modificarClase();
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

function modificarClase() {
    global $conn;
    $id = $_SESSION['id'];

    $materiaNueva = $_POST['materiaNueva'];
    $cursoNuevo = $_POST['cursoNuevo'];
    $letraNueva = $_POST['letraNueva'];

    $idclaseActual = $_POST['idclaseActual'];

    $idmateriaNueva = getIdMateria($materiaNueva, $conn);

    // Ver si la clase ya existe
    $result = mysqli_query($conn, "SELECT * FROM clase WHERE curso = '$cursoNuevo' AND letra = '$letraNueva' AND materia_idmateria = '$idmateriaNueva';");
    if (mysqli_num_rows($result) > 0) {
        echo 2;
        return;
    } else {
        // Insertar clase
        $sql = "UPDATE clase 
        SET curso = '$cursoNuevo', letra = '$letraNueva' , materia_idmateria = '$idmateriaNueva'
        WHERE idclase = '$idclaseActual';";
        mysqli_query($conn, $sql);
        echo 1;
        return;
    }
}
?>