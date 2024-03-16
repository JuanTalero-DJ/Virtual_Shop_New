<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pedido</title>
    <meta charset="utf-8">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC:wght@300&family=Jost:wght@300&family=Roboto:wght@100;300&display=swap"
        rel="stylesheet" />
    <script src="https://kit.fontawesome.com/2943493a50.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../Styles/style.css" />
    <link rel="stylesheet" href="../ProductList/ProductListStyle.css" />
    <link rel="stylesheet" href="../../Utilitary/navStyle.css" />
    <script src="../../Utilitary/searchProduct.js" type="text/javascript"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <style>
        .container {
            width: 100%;
            padding: 50px;
        }

        .table {
            width: 65%;
            float: left;
        }

        .shipAddr {
            width: 30%;
            float: left;
            margin-left: 30px;
        }

        .footBtn {
            width: 95%;
            float: left;
        }

        .orderBtn {
            float: right;
        }
    </style>
</head>
</head>

<body>
    <div class="nav">
        <?php
        include_once '../Login/Session.php';
        validateSession();
        include_once '../../Utilitary/nav.php';

        include_once '../../DataBase/DbConection.php';
        $db = conexion();

        $iduser = $_SESSION['user']['IdCliente'];
        $query = $db->query("SELECT * FROM Cliente WHERE IdCliente = '$iduser'");
        $custRow = $query->fetch_assoc();

        $items = $db->query("SELECT b.Nombre,a.IdItemPedido,a.Cantidad,b.ValorUnitario,a.SubTotal FROM itempedido as a join producto as b on a.idproducto = b.idproducto WHERE IdPedido = '" . $_GET['id'] . "'");

        ?>
        <div id="contenido">
            <div class="container">
                <!-- <div class="container">
                <h1>Estado del pedido</h1>
                <p>Su pedido se ha enviado correctamente. El ID del pedido es #</p>
                <button class="home" onclick="window.location.href='../ProductList/Index.php'">Volver al inicio <i
                        class="fa-solid fa-house-chimney-window"></i></button>
            </div> -->

                <h1>Pedido No.
                    <?php echo $_GET['id']; ?>
                </h1>
                <div class="row">
                    <div class="col-md">
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
                                if ($items->num_rows > 0) {
                                    //get cart items from session   
                                    while ($item = mysqli_fetch_assoc($items)) {

                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $item["Nombre"]; ?>
                                            </td>
                                            <td>
                                                <?php echo '$' . $item["ValorUnitario"] . ''; ?>
                                            </td>
                                            <td>
                                                <?php echo $item["Cantidad"]; ?>
                                            </td>
                                            <td>
                                                <?php echo '$' . $item["SubTotal"] . ''; ?>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="4">
                                            <p>No hay items en su pedido......</p>
                                        </td>
                                    <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md">
                        <div class="col-md-4">
                            <h2>Seleccionar método de pago</h2>
                            <div class="list-group">
                                <a href="#" class="list-group-item" id="pagar_efectivo">Pagar en efectivo</a>
                                <a href="#" class="list-group-item" id="pagar_tarjeta">Pagar con tarjeta de
                                    crédito/débito</a>
                                <!-- Agrega aquí otros métodos de pago si es necesario -->
                            </div>
                            <div id="metodo_pago_seleccionado"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="shipAddr">
                                <h4>Detalles de envío</h4>
                                <p>Nombre:
                                    <?php echo $custRow['NombreCliente'] ?>
                                </p>
                                <p>Teléfono 1:
                                    <?php echo $custRow['NumTelefonico1']; ?>
                                </p>
                                <p>Teléfono 2:
                                    <?php echo $custRow['NumTelefonico2']; ?>
                                </p>
                                <p>Dirección:
                                    <?php echo $custRow['Direccion']; ?>
                                </p>
                                <p>Codigo postal:
                                    <?php echo $custRow['CodigoPostal']; ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>

                    <div class="footBtn">
                        <a onclick="window.location.href='../ProductList/Index.php'" class="btn btn-warning"><i
                                class="glyphicon glyphicon-menu-left"></i> Seguir comprando</a>
                        <a href="cartAction.php?action=placeOrder" class="btn btn-success orderBtn">Realizar pedido <i
                                class="glyphicon glyphicon-menu-right"></i></a>
                    </div>
                </div>


</body>

</html>
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
                    $('#metodo_pago_seleccionado').append(response);
                    $('#boton_pagar').prop('disabled', false); // Habilitar el botón de pagar
                }
            });
        }
    });
</script>