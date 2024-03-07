<?php
function conexion()
{
    $servername = "localhost";
    $username = "root";
    $passw = "";
    $db = "ventas";

    $conn = new mysqli($servername, $username, $passw, $db);

    if ($conn->connect_error) {
        die("Conexión fallida:" . $conn->connect_error);
    }

    return $conn;
}
?>