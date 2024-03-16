<?php
// pagar_tarjeta.php

if(isset($_GET['metodo']) && $_GET['metodo'] === 'tarjeta') {
    // Mostrar el formulario solo si no se han enviado los datos
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        // Si no se han enviado los datos mediante POST, mostrar el formulario
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar con tarjeta de crédito/débito</title>
    
</head>

<body>
    <div class="container">
        <h2>Pagar con tarjeta de crédito/débito</h2>
        <form action="guardar_info_tarjeta.php" method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre en la tarjeta" required>
            </div>
            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" class="form-control" id="numero" name="numero" placeholder="Número de tarjeta" required>
            </div>
            <div class="row">
                <div class="form-group col-xs-6">
                    <label for="fecha">Expira:</label>
                    <input type="text" class="form-control" id="fecha" name="fecha" placeholder="MM/YY" required>
                </div>
                <div class="form-group col-xs-6">
                    <label for="cvv">CVV:</label>
                    <input type="text" class="form-control" id="cvv" name="cvv" placeholder="CVV" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar información de pago</button>
        </form>
    </div>
</body>

</html>
<?php
    } else {
        // Procesar los datos del formulario
        // Aquí puedes incluir el código para guardar la información en la base de datos u otro procesamiento necesario
        // Por ahora, simplemente mostraremos un mensaje indicando que los datos se han enviado correctamente
        echo "Los datos del formulario se han enviado correctamente.";
    }
} else {
    // Redireccionar o mostrar un error si el método de pago no es válido
    header("Location: select_payment_method.php");
    exit;
}
?>
