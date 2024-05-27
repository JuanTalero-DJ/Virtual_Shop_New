
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar en efectivo</title>

</head>

<body>
    <div>
        <h2>Pagar en efectivo</h2>
        <form action="pago.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="tipoPago" value="1">
            <input type="hidden" name="idPedido" value="<?php echo $_GET['pedido']; ?>">
            <div class="form-group">
                <label for="pago_contraentrega">Pagar contra entrega:</label>
                <input type="checkbox" id="pago_contraentrega" name="pago_contraentrega" value="si">
            </div>
            <!-- <div id="comprobante_pago" style="display: none;">
                <div class="form-group">
                    <label for="comprobante">Adjuntar comprobante de pago:</label>
                    <input type="file" class="form-control-file" id="comprobante" name="comprobante" required>
                </div>
            </div> -->
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