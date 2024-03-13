<?php
function conexion()
{
    $servername = "localhost";
    $username = "root";
    $passw = "";
    $db = "tiendavirtual";

    $conn = new mysqli($servername, $username, $passw, $db);

    if ($conn->connect_error) {
        die("Conexión fallida:" . $conn->connect_error);
    }

    return $conn;
}
?>