<?php 
require_once "conexion.php";

session_start();
$_SESSION['user'] = $_GET['user'];
$_SESSION['id'] = $_GET['id'];

$password_asteriscos = str_repeat("*", strlen(getPass($conn)));
$password = getPass($conn);

function getPass($conn){
    $id = $_SESSION['id'];

    $sql = "SELECT 'password' FROM usuario WHERE idusuario = '$id';";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $correo = 
        $password = $row["password"];

        // Devolver el correo electrónico
        return $password;
    } else {
        return null;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}

function getCorreo($conn){
    $id = $_SESSION['id'];

    $sql = "SELECT correo FROM usuario WHERE idusuario = '$id';";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $correo = $row["correo"];

        // Devolver el correo electrónico
        echo $correo;
        return $correo;
    } else {
        return null;
    }

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
    <title>Escuelingo - <?php echo $_SESSION["user"] ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/utils.js"></script>
    <link rel="stylesheet" href="css/feedLight.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body style="background-color: rgb(255, 255, 255);">
    <div class="alerta" id="alerta">
        <b id="alerta-mensaje"></b>
    </div>
    <br>
    <div class="main-frame" style="height: 34rem;">
        <div class="topnav">
            <a id="hrefclase" href="feed.php?PHPSESSID=<?php echo session_id(); ?>&user=<?php echo $_SESSION['user']; ?>&id=<?php echo $_SESSION['id']; ?>" id="alumnos">Clases</a>
            <a href="alumnos.php?PHPSESSID=<?php echo session_id(); ?>&user=<?php echo $_SESSION['user']; ?>&id=<?php echo $_SESSION['id']; ?>" id="alumnos">Alumnos</a>
            <a href="#acerca">Acerca</a>
            <a class="active" href="usuario.php?PHPSESSID=<?php echo session_id(); ?>&user=<?php echo $_SESSION['user']; ?>&id=<?php echo $_SESSION['id']; ?>" id="nombre_cuenta"><?php echo($_SESSION['user']);?></a>
        </div>

        <form id="f1" autocomplete="off" class="main-frame-form" method="post" name="f1">
            <div class="mb-3">
                <p>Nombre de usuario:</p>
                <input type="text" class="form-control" placeholder="Nuevo nombre de usuario" id="nombre" value="<?php echo $_SESSION['user'];?>">
            </div>
            <div class="mb-3">
                <p>Contraseña actual:</p>
                <input type="password" class="form-control" id="pass-actual">
            </div>
            <div class="mb-3">
                <p>Contraseña nueva:</p>
                <input type="password" class="form-control" id="pass-nueva">
            </div>

            <div class="mb-3">
                <p>Correo:</p>
                <input type="email" class="form-control" id="correo" placeholder="Nuevo correo" value="<?php getCorreo($conn);?>">
            </div>
            
            <button type="button" onclick="modificarUsuario();" class="btn btn-primary" id="continuar-btn">Guardar</button>
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