<?php

include_once '../../Database/DbConection.php';
$tipoPago = $_POST['tipoPago'];
$idPedido = $_POST['idPedido'];
$numeroTarjeta = "";
$fechaExpiracion = "";
$cvv = "";
$mensaje = "";
if ($tipoPago == "2") {
    $numeroTarjeta = $_POST['numero'];
    $fechaExpiracion = $_POST['fecha'];
    $cvv = $_POST['cvv'];

    if (strlen($cvv) < 3) {
        $mensaje = "Cvv no valido";

    }
    if (strlen($numeroTarjeta) < 19) {
        $mensaje = "Número de tarjeta no valido";

    }
    if (strlen($fechaExpiracion) < 5) {
        $mensaje = "Fecha de expiracion no valido";

    }
    if ($mensaje != "") {
        echo '<script type="text/javascript">alert("' . $mensaje . '");window.history.back();</script>';
        return;
    }
}
$conn = conexion();
//Estado de pedido: 1 disponible, 2 pago, 3 cancelado
$find = "SELECT Estado, Total  FROM Pedido WHERE IdPedido=$idPedido";
$result = mysqli_query($conn, $find);
$dataPedido = mysqli_fetch_assoc($result);

if ($dataPedido["Estado"] == 2) {
    $mensaje = "El pedido no. $idPedido, ya se encuntra facturado y está en proceso de entrega";
}

if ($mensaje != "") {
    echo '<script type="text/javascript">alert("' . $mensaje . '");window.history.back();</script>';
    return;
}


$querys = '';
$numencode = base64_encode($numeroTarjeta);
$insert = "INSERT INTO pagos (IdPedido,TipoPago,NumeroTarjeta,FechaPago,Monto) 
    VALUES ('$idPedido','$tipoPago','$numencode','" . date("Y-m-d H:i:s") . "'," . $dataPedido["Total"] . ")";
mysqli_query($conn, $insert);

$query = "SELECT * FROM itempedido WHERE IdPedido = $idPedido";
$listItems = mysqli_query($conn, $query);

while ($fila = mysqli_fetch_assoc($listItems)) {
    $cantidadItem = $fila['Cantidad'];
    $querys .= "UPDATE Producto SET Cantidad = Cantidad - $cantidadItem
    WHERE IdProducto = " . $fila['IdProducto'] . ";";
}

$query .= "UPDATE pedido SET Estado = 2 WHERE IdPedido =  $idPedido;";
$updateOrderItems = $conn->multi_query($querys);

if ($mensaje != "") {
    echo '<script type="text/javascript">alert("' . $mensaje . '");window.location.href="index.html";</script>';
    return;
}

echo '<script type="text/javascript">alert("Pago realizado correctamente");window.location.href="../ProductList/Index.php";</script>';
?>