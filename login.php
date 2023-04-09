<?php
require_once "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'login') {
    login();
}

function login(){
    global $conn;
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    // Consulta preparada para verificar si las credenciales del usuario son válidas
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE username=? AND password=?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si la consulta devuelve un resultado, el inicio de sesión es exitoso
    if ($result->num_rows > 0) {
        // Obtener los valores de las columnas para el usuario
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $id = $row['idusuario'];

        // Establecer las variables de sesión
        session_start();
        $_SESSION['user'] = $username;
        $_SESSION['id'] = $id;

        // Redirigir al usuario a la página de inicio
        header("Location: feed.php");
        exit();
    } else {
        echo 1;
        exit();
    }
    // cerrar la conexión a la base de datos
    $conn->close();
}
?>
