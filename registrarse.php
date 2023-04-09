<?php
require_once "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'insert') {
    insert();
}

function insert() {
    global $conn;
    $username = $_POST["user"];
    $password = $_POST["pass"];
    $correo = $_POST["email"];

    // Check if email is already taken
    $result = mysqli_query($conn, "SELECT * FROM usuario WHERE correo = '$correo'");
    
    if (mysqli_num_rows($result) > 0) {
        echo 2;
        return;
    } else {
      // Insert user data into the database
      $query = "INSERT INTO usuario (username, password, correo)
      VALUES ('$username', '$password', '$correo');";

      mysqli_query($conn, $query);

      // Output
      echo 1;
    }

    $conn->close();
}

?>
