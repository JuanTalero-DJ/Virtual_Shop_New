<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar con tarjeta de crédito/débito</title>


</head>


<body>
    <div>
        <h2>Pagar con tarjeta de crédito/débito</h2>
        <form action="pago.php" method="post">
            <input type="hidden" name="tipoPago" value="2">
            <input type="hidden" name="idPedido" value="<?php echo $_GET['pedido']; ?>">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre en la tarjeta"
                    required>
            </div>
            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" class="form-control" id="number" name="numero" placeholder="Número de tarjeta"
                    oninput="formatCreditNumber()" maxlength="19" required>
            </div>
            <div class="row">
                <div class="form-group col-xs-3">
                    <label for="fecha">Expira:</label>
                    <input type="text" class="form-control" id="fecha" name="fecha" placeholder="MM/YY" maxlength="5"
                        oninput="formatFechaExpiracion()" required>
                </div>
                <div class="form-group col-xs-3">
                    <label for="cvv">CVV:</label>
                    <input type="number" class="form-control" id="cvv" name="cvv" placeholder="CVV" maxlength="3"
                        required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Pagar</button>
        </form>
    </div>
</body>

</html>

<script>
    function formatCreditNumber() {
        let numberCreditCard = $("#number").val();
        if (numberCreditCard.length == 4 || numberCreditCard.length == 9 ||
            numberCreditCard.length == 14) {
            $("#number").val(numberCreditCard += '-');
        }

    }

    function formatFechaExpiracion() {
        let numberCvv = $("#fecha").val();
        if (numberCvv.length == 2) {
            $("#fecha").val(numberCvv += '/');
        }

    }
</script>