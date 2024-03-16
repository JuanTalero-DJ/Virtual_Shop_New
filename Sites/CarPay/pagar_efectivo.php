<?php
// pagar_efectivo.php

if(isset($_GET['metodo']) && $_GET['metodo'] === 'efectivo') {
    // No hay procesamiento real en este ejemplo, solo se mostrará el formulario para ingresar los datos
} else {
    // Redireccionar o mostrar un error si el método de pago no es válido
    header("Location: select_payment_method.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar en efectivo</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Pagar en efectivo</h2>
        <form action="guardar_info_efectivo.php" method="post" enctype="multipart/form-data">
            
            <div class="form-group">
                <label for="pago_contraentrega">Pagar contra entrega:</label>
                <input type="checkbox" id="pago_contraentrega" name="pago_contraentrega" value="si">
            </div>
            <div id="comprobante_pago" style="display: none;">
                <div class="form-group">
                    <label for="comprobante">Adjuntar comprobante de pago:</label>
                    <input type="file" class="form-control-file" id="comprobante" name="comprobante" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Pagar</button>
        </form>
    </div>

    <script>
        document.getElementById('pago_contraentrega').addEventListener('change', function () {
            if (this.checked) {
                document.getElementById('comprobante_pago').style.display = 'none';
            } else {
                document.getElementById('comprobante_pago').style.display = 'block';
            }
        });
    </script>
</body>

</html>
