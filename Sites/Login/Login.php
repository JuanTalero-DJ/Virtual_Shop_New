<?php
include_once '../../DataBase/DbConection.php';
$user = $_POST['email'];
$pass = $_POST['pass'];
$conn = conexion();
$pssw = base64_encode($pass);
$sql = "SELECT * FROM cliente  WHERE email = '$user' AND Contraseña = '$pssw'";
$resultado = mysqli_query($conn, $sql);
$data=mysqli_fetch_assoc($resultado);
if ($data == null) {
  echo'<script type="text/javascript">alert("El usuario o contraseña ingresados no son validos");window.location.href="../../index.html";</script>';
} else {
  session_start();
  $_SESSION["user"]=$data;
  header('Location:../ProductList/index.php');
}
x($resultado);
mysqli_close($conn);

?>