<?php 
require_once "conexion.php";

session_start();
// Obtener las variables de sesión de nombre de usuario y ID de usuario
$user = $_SESSION['user'];
$id = $_SESSION['id'];

function pintarTabla($id, $conn){
    // Recuperar las variables de sesión
    $user = $_SESSION['user'];
    $id = $_SESSION['id'];

    // Realizar una consulta en la base de datos
    $sql = "SELECT idclase, curso, letra, alumnos, materia.nombre FROM clase INNER JOIN materia ON clase.materia_idmateria = materia.idmateria 
    WHERE usuario_idusuario = '$id';";

    $result = $conn->query($sql);

    // Generar el código HTML para la tabla
    echo "<table class='table table-hover'>";
    echo "<thead><tr><th scope='col'>ID</th><th scope='col'>Curso</th><th scope='col'>Letra</th><th scope='col'>Alumnos</th><th scope='col'>Materia</th></tr></thead>";
    echo "<tbody>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["idclase"] . "</td><td>" . $row["curso"] . "</td><td>" . $row["letra"] . "</td><td>" . $row["alumnos"] . "</td><td>" . $row["nombre"] . "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No hay resultados</td></tr>";
    }
    echo "</tbody>";
    echo "</table>";

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escuelingo</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/utils.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/feedLight.css">
</head>
<body style="background-color: rgb(255, 255, 255);">
    <div class="alerta" id="alerta">
        <b id="alerta-mensaje">Por favor, introduce una contraseña</b>
    </div>
    <br>
    <div class="main-frame">
        <div class="topnav">
            <a id="hrefclase" class="active" href="#clases">Clases</a>
            <a href="alumnos.php?PHPSESSID=<?php echo session_id(); ?>&user=<?php echo $_SESSION['user']; ?>&id=<?php echo $_SESSION['id']; ?>" id="alumnos">Alumnos</a>
            <a href="#acerca">Acerca</a>
            <a href="usuario.php?PHPSESSID=<?php echo session_id(); ?>&user=<?php echo $_SESSION['user']; ?>&id=<?php echo $_SESSION['id']; ?>" id="nombre_cuenta"><?php echo($_SESSION['user']);?></a>
        </div>

        <div class="clases_section">
            <div class="tabla_clases">
                <?php pintarTabla($_SESSION['id'], $conn);?>
            </div>
            <div class="botonera">
                <button type="button" class="btn btn-outline-primary" onclick="redirectNuevaClase();">Nueva clase</button>
                <button type="button" class="btn btn-outline-primary" onclick="pasarDatosClase();">Modificar</button>
                <button type="button" class="btn btn-outline-danger">Eliminar</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script>
        var rows = document.querySelectorAll(".table tbody tr");
        var alertaDiv = document.getElementById("alerta");
        alertaDiv.style.pointerEvents = "none";
        alertaDiv.style.display = "none";

        rows.forEach(function(row) {
            row.addEventListener("click", function() {
                // Eliminar la selección anterior
                var selectedRow = document.querySelector(".table .selected");
                if (selectedRow !== null) {
                    selectedRow.classList.remove("selected");
                    selectedRow.style.backgroundColor = "";
                }
                
                // Seleccionar la nueva fila
                this.classList.add("selected");
                this.style.backgroundColor = "lightblue";
            });
        });


        $(document).ready(function() {
            $('.btn.btn-outline-danger').on('click', function() {
                // Obtener el ID de la fila seleccionada
                var idclase = $('.table .selected td:first-child').text();

                // Realizar una solicitud AJAX al servidor para eliminar la fila correspondiente
                $.ajax({
                    url: 'procesarEliminarClase.php',
                    type: 'POST',
                    data: {idclase: idclase},
                    success: function(response) {
                        // Si la eliminación se realiza correctamente, eliminar la fila de la tabla
                        if (response == 'success') {
                            $('.table .selected').remove();
                            alertaOk("Clase eliminada");
                        }
                    }
                });
            });
        });
    </script>

</body>
</html>