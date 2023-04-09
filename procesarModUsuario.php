<?php
require_once "conexion.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'modificarUsuario') {
    modificarUsuario();
}

function modificarUsuario() {
    global $conn;
    $id = $_SESSION['id'];

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $pass_actual = $_POST['pass_actual'];
    $pass_nueva = $_POST['pass_nueva'];


    // Ver si la contrasena es correcta
    $comprobar = mysqli_query($conn, "SELECT * FROM usuario WHERE password = '$pass_actual' AND idusuario = '$id';");
    if (mysqli_num_rows($comprobar) > 0) {

        // Ver si el usuario ya existe
        $result = mysqli_query($conn, "SELECT * FROM usuario WHERE username = '$nombre' AND correo = '$correo' AND 'password' = '$pass_nueva';");
        
        if (mysqli_num_rows($result) > 0) {
            echo 2;
            return;
        } else {
            $sql = "UPDATE usuario SET username = '$nombre', correo = '$correo' , password = '$pass_nueva' WHERE idusuario = '$id';";
            mysqli_query($conn, $sql);
            $_SESSION['user'] = $nombre;
            echo 1;
            return;
        }

    } else {
        echo 3;
        return;
    }

    
    


    
}
?>