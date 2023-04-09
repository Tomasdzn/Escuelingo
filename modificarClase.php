<?php
require_once('conexion.php');
session_start();

// Obtener los parámetros de la URL
$idclase = $_GET['idclase'];
$curso = $_GET['curso'];
$letra = $_GET['letra'];
$alumnos = $_GET['alumnos'];
$materia = $_GET['materia'];

// Parametros de la sesión
$user = $_SESSION['user'];
$id = $_SESSION['id'];

function cargarMaterias($conn){
    // Recuperar las variables de sesión
    $id = $_SESSION['id'];

    // Realizar una consulta en la base de datos
    $sql = "SELECT nombre FROM materia;";
    $index = 1;

    $result = $conn->query($sql);

    echo '<select id="materia-select" name="materia" value="materia" class="form-select" aria-label="Default select example">';
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.$row["nombre"].'">'.$row["nombre"].'</option>';
            $index++;
        }
    } else {
        echo '<option value="0">ERROR DE CARGA</option>';
    }
    echo '</select>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escuelingo - Modificar clase</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/utils.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/feedLight.css">
</head>
<body style="background-color: rgb(255, 255, 255);">
    <div class="alerta" id="alerta">
        <b id="alerta-mensaje"></b>
    </div>
    <br><br>
    <div class="main-frame">
    <form id="form-crear-clase" autocomplete="off" name="f1" class="main-frame-form" method="post">
            <b>ID de la clase: <?php echo "<b id='idclaseActual'>$idclase</b>"; ?></b>
            <div class="mb-3">
                <label for="" class="form-label">Curso: <?php echo "<b id='cursoActual'>$curso</b>"; ?></label>
                <select id="curso-select" name="curso" value="curso" class="form-select" aria-label="Default select example">
                    <option value="1" default>1 (Primero de ESO)</option>
                    <option value="2">2 (Segundo de ESO)</option>
                    <option value="3">3 (Tercero de ESO)</option>
                    <option value="4">4 (Cuarto de ESO)</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Materia: <?php echo "<b id='materiaActual'>$materia</b>"; ?></label>
                <?php cargarMaterias($conn); ?>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Letra: <?php echo "<b id='letraActual'>$letra</b>"; ?></label>
                <select id="letra-select" name="letra" value="letra" class="form-select" aria-label="Default select example">
                    <option value="1" default>A</option>
                    <option value="2">B</option>
                    <option value="3">C</option>
                    <option value="4">D</option>
                    <option value="4">E</option>
                    <option value="4">F</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" name="accion" value="crear_clase" onclick="modificarClase();">Modificar</button>
            <button type="button" class="btn btn-secondary" onclick="redirectModificarClase();">Volver</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script>
        var alertaDiv = document.getElementById("alerta");
        alertaDiv.style.pointerEvents = "none";
        alertaDiv.style.display = "none";
    </script>

</body>
</html>