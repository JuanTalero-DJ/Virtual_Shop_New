<?php

	include_once '../../Database/DbConection.php';
	include_once '../Login/Session.php';
    validateSession();

	$numeroIdentificacion = $_SESSION['user']['NumIdentifiacion'] ;
	$telefono1 =$_POST['Telefono1'];
	$telefono2 =$_POST['Telefono2'];
	$direccion =$_POST['Direccion'];
	$codigoPostal =$_POST['CodigoPostal'];
	$correo =$_POST['Correo'];
	$clave =$_POST['Clave'];
	$confClave =$_POST['ConfirmarClave'];
	$conn = conexion();
    $mensaje = "";

	if ($clave!= $confClave){	
		$mensaje = "Las contraseñas ingresadas no coinciden";
		
	}else{

        $find = "SELECT 'NumIdentifiacion' , 'Email' FROM Cliente
        WHERE Email= '$correo' AND NumIdentifiacion != $numeroIdentificacion" ;
        $result = mysqli_query($conn, $find);
		
        if($result-> num_rows > 0){
			
			$data=mysqli_fetch_assoc($result);
            if ($data["Email"] = $correo ){
                $mensaje = "El usuario con correo $correo, ya existe en el sistema";
            }
        }
    }

    if($mensaje != ""){
        echo'<script type="text/javascript">alert("'.$mensaje.'");window.location.href="viewEditUser.php";</script>';
		return;
    }

	
    $encodepssw = base64_encode($clave);
	if($encodepssw == "" ){
		$encodepssw = $_SESSION['user']['Contraseña'];
	}
	$insert = "UPDATE cliente SET  
	NumTelefonico1 = '$telefono1',
	NumTelefonico2 ='$telefono2' ,
	Direccion = '$direccion', 
	CodigoPostal = '$codigoPostal', 
	Email = '$correo', 
	Contraseña = '$encodepssw'";

	$query= mysqli_query($conn,$insert);
	// $data = mysqli_fetch_assoc($query);

	echo'<script type="text/javascript">alert("Guardado exitoso");window.location.href="../ProductList/Index.php";</script>';
?>


