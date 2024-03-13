<?php

	include_once '../../Database/DbConection.php';
	$tipoIdentificacion = $_POST['TipoIdentificacion'];
	$numeroIdentificacion =$_POST['NumeroIdentificacion'];
	$nombre =$_POST['Nombre'];
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
        WHERE NumIdentifiacion='$numeroIdentificacion' or Email= '$correo'";
        $result = mysqli_query($conn, $find);
        $data=mysqli_fetch_assoc($result);

        if($data != null){

            if ($data["NumIdentifiacion"] = $numeroIdentificacion){
                $mensaje = "El usuario con numero de identificacion $numeroIdentificacion, ya existe en el sistema";
            }
            
            if ($data["Email"] = $correo){
                $mensaje = "El usuario con correo $correo, ya existe en el sistema";
            }
        }
    }

    if($mensaje != ""){
        echo'<script type="text/javascript">alert("'.$mensaje.'");window.location.href="index.html";</script>';
		return;
    }

    $encodepssw = base64_encode($clave);
	$insert = "INSERT INTO cliente (NombreCliente,NumIdentifiacion,TipoIdentificacion,NumTelefonico1,NumTelefonico2,Direccion, CodigoPostal, Email, Contraseña) 
    VALUES ('$nombre','$numeroIdentificacion','$tipoIdentificacion','$telefono1','$telefono2','$direccion','$codigoPostal','$correo','$encodepssw')";
	$query= mysqli_query($conn,$insert);
	// $data = mysqli_fetch_assoc($query);

	echo'<script type="text/javascript">alert("Guardado exitoso");window.location.href="../../index.php";</script>';
?>


