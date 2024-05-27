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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="../../Utilitary/searchProduct.js" type="text/javascript"></script>

    <style>
        .container {
            width: 80%;
            padding: 50px;
            display: grid;
            grid-gap: 10px;
            grid-auto-rows: minmax(100px, auto);
        }

        .table {
            width: 100%;
            float: left;
        }

        .shipAddr {
            width: 100%;
            float: left;
        }

        .footBtn {
            width: 95%;
            float: left;
        }

        .orderBtn {
            float: right;
        }

        .itemTable {
            grid-column: 1;
            grid-row: 1;
        }

        .payMethod {
            grid-column: 2;
            grid-row: 1;
            display: flex;
            justify-content: end;
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
        ?>
    </div>

    <?php


    include_once '../../DataBase/DbConection.php';
    $db = conexion();

    $iduser = $_SESSION['user']['IdCliente'];
    $query = $db->query("SELECT * FROM Cliente WHERE IdCliente = '$iduser'");
    $custRow = $query->fetch_assoc();

    $items = $db->query("SELECT b.Nombre,a.IdItemPedido,a.Cantidad,b.ValorUnitario,a.SubTotal FROM itempedido as a join producto as b on a.idproducto = b.idproducto WHERE IdPedido = '" . $_GET['id'] . "'");

    ?>
    <div id="contenido">
        <div class="container">
            <div class="itemTable">
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
                                                <?php echo '$' . number_format($item["SubTotal"], 2) . ''; ?>
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
                </div>
                <div class="row">
                    <div class="col-md-12">
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
                </div>

                <div class="footBtn">
                    <a onclick="window.location.href='../ProductList/Index.php'" class="btn btn-warning"><i
                            class="glyphicon glyphicon-menu-left"></i> Seguir comprando</a>
                    <a href="" class="btn btn-danger orderBtn">Cancelar pedido <i class="fa-solid fa-square-xmark"></i></a>
                </div>

            </div>
            <div class="payMethod">
                <div class="col-md">
                    <div class="col-md-12" style="width: 419.031px;">
                        <h2>Seleccionar método de pago </h2>
                        <div class="list-group">
                            <a href="#" class="list-group-item" id="pagar_efectivo"> <i
                                    class="fa-solid fa-money-bill"></i> &nbsp &nbsp Pagar en efectivo </a>
                            <a href="#" class="list-group-item" id="pagar_tarjeta"><i
                                    class="fa-solid fa-credit-card"></i> &nbsp &nbsp Pagar con tarjeta de
                                crédito/débito</a>
                        </div>
                        <div id="metodo_pago_seleccionado"></div>
                    </div>
                </div>
            </div>

        </div>

    </div>


</body>

</html>
<script>
    $(document).ready(function () {
        $('#pagar_efectivo').click(function () {
            mostrarMetodoPago('pagar_efectivo.php?pedido=<?php echo $_GET['id']; ?>');
        });

        $('#pagar_tarjeta').click(function () {
            mostrarMetodoPago('pagar_tarjeta.php?pedido=<?php echo $_GET['id']; ?>');
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