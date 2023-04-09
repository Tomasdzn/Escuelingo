<?php
require_once('conexion.php');
session_start();

// Obtener los parámetros de la URL
$idalumno = $_GET['idalumno'];
$nombre = $_GET['nombre'];
$apellido = $_GET['apellido'];
$correo = $_GET['correo'];
$ano = $_GET['ano'];
$numero = $_GET['numero'];
$estado = $_GET['estado'];
$clase = $_GET['clase'];

// Parametros de la sesión
$user = $_SESSION['user'];
$id = $_SESSION['id'];

function cargarClases($conn,$clase){
    // Recuperar las variables de sesión
    $id = $_SESSION['id'];

    // Realizar una consulta en la base de datos
    $sql = "SELECT * FROM clase WHERE usuario_idusuario = '$id';";
    $index = 1;

    $result = $conn->query($sql);

    echo '<select id="al_clase" name="al_clase" value="clase" class="form-select">';
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $cursoCompleto = $row["curso"]. "" .$row["letra"];
            if($cursoCompleto == $clase){
                echo '<option value="'.$row["idclase"].'" selected>'.$row["curso"].$row["letra"].'</option>';
            }else{
                echo '<option value="'.$row["idclase"].'">'.$row["curso"].$row["letra"].'</option>';
            }
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
                <b>ID del alumno: <?php echo "<b id='idalumnoActual'>$idalumno</b>"; ?></b>
                <div class="mb-3">
                    <label for="al_name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="al_name" name="al_name" value='<?php echo $nombre ?>'>
                </div>
                <div class="mb-3">
                    <label for="al_apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="al_apellido" name="al_apellido" value='<?php echo $apellido ?>'>
                </div>
                <div class="mb-3">
                    <label for="al_correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="al_correo" name="al_correo" value='<?php echo $correo ?>'>
                </div>
                <div class="mb-3">
                    <label for="al_fecha" class="form-label">Fecha nacimiento</label>
                    <input type="date" class="form-control" id="al_fecha" name="al_fecha" value='<?php echo $ano ?>'>
                </div>
                <div class="mb-3">
                    <label for="al_numero" class="form-label">Numero telefono</label>
                    <input type="text" class="form-control" id="al_numero" name="al_numero" value='<?php echo $numero ?>'>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Estado</label>
                    <br>
                    <select name="al_estado" class="form-select" id="al_estado" value='<?php echo $estado ?>'>
                        <option value="a">Activo</option>
                        <option value="i">Inactivo</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Asignar</label>
                    <?php cargarClases($conn,$clase); ?>
                </div>
            </div>
                <button type="button" class="btn btn-primary" name="accion" onclick="modificarAlumno();">Modificar</button>
                <button type="button" class="btn btn-secondary" onclick="redirectModificarAlumno();">Volver</button>
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