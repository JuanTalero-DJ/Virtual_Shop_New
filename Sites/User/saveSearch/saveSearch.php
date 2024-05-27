<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	include_once '../../../Database/DbConection.php';
	include_once '../../Login/Session.php';
	validateSession();

	$idCliente = $_SESSION['user']['IdCliente'];
	$idCategoria = $_POST['idCategoria'];
	$fechaBusqueda = date('Y-m-d H:i:s');
	$palabraClave = $_POST['palabraClave'];
	$conn = conexion();

	

	$sql = "SELECT * FROM BusquedasCliente  WHERE IdCategoria = '$idCategoria' OR PalabraClave like '%$palabraClave%'";
	$resultado = mysqli_query($conn, $sql);

	if ($resultado->num_rows ==0) {

		$sql = "SELECT IdBusquedaCliente FROM BusquedasCliente  WHERE IdCliente = '$idCliente'";
		$resultado = mysqli_query($conn, $sql);

		if($resultado->num_rows >= 50){
			$primer_fila = $stmt->fetch(PDO::FETCH_ASSOC);
			$sql = "DELETE FROM BusquedasCliente  WHERE IdCategoria = ". $primer_fila['IdBusquedaCliente'];
			$resultado = mysqli_query($conn, $sql);
		}

		$insert = "INSERT INTO BusquedasCliente (IdCliente,IdCategoria,FechaBusqueda,PalabraClave) 
    	VALUES ('$idCliente',$idCategoria,'$fechaBusqueda','$palabraClave')";

		$query = mysqli_query($conn, $insert);

	}
}
?>