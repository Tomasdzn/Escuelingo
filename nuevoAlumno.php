<?php
require_once('conexion.php');
session_start();
$user = $_SESSION['user'];
$id = $_SESSION['id'];

function cargarClases($conn){
    // Recuperar las variables de sesión
    $id = $_SESSION['id'];

    // Realizar una consulta en la base de datos
    $sql = "SELECT * FROM clase WHERE usuario_idusuario = '$id';";
    $index = 1;

    $result = $conn->query($sql);

    echo '<select id="al_clase" name="al_clase" value="clase" class="form-select">';
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.$row["idclase"].'">'.$row["curso"].$row["letra"].'</option>';
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
    <title>Escuelingo - Crear alumno</title>
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
    <div class="main-frame" style="height: 46rem;">
        <form id="form-crear-clase" autocomplete="off" name="f1" class="main-frame-form" method="post">
            <div class="opciones_scroll">
                <b>Añade una nuevo alumno</b>
                <div class="mb-3">
                    <label for="al_name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="al_name" name="al_name">
                </div>
                <div class="mb-3">
                    <label for="al_apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="al_apellido" name="al_apellido">
                </div>
                <div class="mb-3">
                    <label for="al_correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="al_correo" name="al_correo">
                </div>
                <div class="mb-3">
                    <label for="al_fecha" class="form-label">Fecha nacimiento</label>
                    <input type="date" class="form-control" id="al_fecha" name="al_fecha">
                </div>
                <div class="mb-3">
                    <label for="al_numero" class="form-label">Numero telefono</label>
                    <input type="text" class="form-control" id="al_numero" name="al_numero">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Estado</label>
                    <br>
                    <select name="al_estado" class="form-select" id="al_estado">
                        <option value="a">Activo</option>
                        <option value="i">Inactivo</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Asignar clase</label>
                    <?php cargarClases($conn); ?>
                </div>
            </div>
                <button type="button" class="btn btn-primary" name="accion" onclick="crearAlumno();">Crear</button>
                <button type="button" class="btn btn-secondary" onclick="redirectNuevoAlumno();">Volver</button>
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