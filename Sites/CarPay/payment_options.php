<?php
include_once '../../DataBase/DbConection.php';
$db = conexion();
// initializ shopping cart class
include 'Cart.php';
$cart = new Cart;

// redirect to home if cart is empty
if($cart->total_items() <= 0){
    header("Location: index.php");
}

// set customer ID in session
$_SESSION['sessCustomerID'] = 1;

$iduser=$_SESSION['user']['IdCliente'];
// get customer details by session customer ID
$query = $db->query("SELECT * FROM Cliente WHERE IdCliente = '$iduser'");
$custRow = $query->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar método de pago</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC:wght@300&family=Jost:wght@300&family=Roboto:wght@100;300&display=swap"
        rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        /* Estilos adicionales */
        .list-group-item {
            cursor: pointer;
        }

        #valor_a_pagar {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
        }

        #items_a_pagar {
            list-style-type: none;
            padding: 0;
        }

        #items_a_pagar li {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }

        #items_a_pagar li:last-child {
            border-bottom: none;
        }

        #boton_pagar {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Vista previa del pedido</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($cart->total_items() > 0){
                            //get cart items from session
                            $cartItems = $cart->contents();
                            foreach($cartItems as $item){
                            ?>
                            <tr>
                                <td><?php echo $item["name"]; ?></td>
                                <td><?php echo '$'.$item["price"].''; ?></td>
                                <td><?php echo $item["qty"]; ?></td>
                                <td><?php echo '$'.$item["subtotal"].''; ?></td>
                            </tr>
                            <?php } }else{ ?>
                            <tr>
                                <td colspan="4">
                                    <p>No hay artículos en su carrito......</p>
                                </td>
                                <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <?php if($cart->total_items() > 0){ ?>
                            <td class="text-center"><strong>Total <?php echo '$'.$cart->total().''; ?></strong></td>
                            <?php } ?>
                        </tr>
                    </tfoot>
                </table>
                <div class="shipAddr">
                    <h4>Detalles de envío</h4>
                    <p>Nombre: <?php echo $custRow['NombreCliente']?></p>
                    <p>Teléfono 1:<?php echo $custRow['NumTelefonico1']; ?></p>
                    <p>Teléfono 2:<?php echo $custRow['NumTelefonico2']; ?></p>
                    <p>Dirección:<?php echo $custRow['Direccion']; ?></p>
                    
                </div>
            </div>
            <div class="col-md-4">
                <h2>Seleccionar método de pago</h2>
                <div class="list-group">
                    <a href="#" class="list-group-item" id="pagar_efectivo">Pagar en efectivo</a>
                    <a href="#" class="list-group-item" id="pagar_tarjeta">Pagar con tarjeta de crédito/débito</a>
                    <!-- Agrega aquí otros métodos de pago si es necesario -->
                </div>
                <div id="metodo_pago_seleccionado"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#pagar_efectivo').click(function () {
                mostrarMetodoPago('pagar_efectivo.php?metodo=efectivo');
            });

            $('#pagar_tarjeta').click(function () {
                mostrarMetodoPago('pagar_tarjeta.php?metodo=tarjeta');
            });

            function mostrarMetodoPago(url) {
                $.ajax({
                    url: url,
                    success: function (response) {
                        $('#metodo_pago_seleccionado').html(response);
                        $('#boton_pagar').prop('disabled', false); // Habilitar el botón de pagar
                    }
                });
            }
        });
    </script>
</body>

</html>
