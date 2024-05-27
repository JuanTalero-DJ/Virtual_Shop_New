<?php
include_once '../../DataBase/DbConection.php';
$db = conexion();
// initializ shopping cart class
include 'Cart.php';
$cart = new Cart;

// redirect to home if cart is empty
if ($cart->total_items() <= 0) {
    header("Location: viewCart.php");
}

// set customer ID in session
$_SESSION['sessCustomerID'] = 1;

$iduser = $_SESSION['user']['IdCliente'];
// get customer details by session customer ID
$query = $db->query("SELECT * FROM Cliente WHERE IdCliente = '$iduser'");
$custRow = $query->fetch_assoc();
?>
<!DOCTYPE html>

<head>
    <title>Realizar Pedido</title>
    <meta charset="utf-8">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC:wght@300&family=Jost:wght@300&family=Roboto:wght@100;300&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/2943493a50.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../Styles/style.css" />
    <link rel="stylesheet" href="../ProductList/ProductListStyle.css" />
    <link rel="stylesheet" href="../../Utilitary/navStyle.css" />

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

        .buttonSearch {
            display: none;
        }

        .inputSearch {
            display: none;
        }
    </style>
</head>

<body>

    <div class="nav">
        <?php
        include_once '../../Utilitary/nav.php';
        ?>
    </div>
    <div class="container">
        <h1>Vista previa del pedido</h1>
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
                if ($cart->total_items() > 0) {
                    //get cart items from session
                    $cartItems = $cart->contents();
                    foreach ($cartItems as $item) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $item["name"]; ?>
                            </td>
                            <td>
                                <?php echo '$' . $item["price"] . ''; ?>
                            </td>
                            <td>
                                <?php echo $item["qty"]; ?>
                            </td>
                            <td>
                                <?php echo '$' . number_format($item["subtotal"], 2) . ''; ?>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="4">
                            <p>No hay artículos en su carrito......</p>
                        </td>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <?php if ($cart->total_items() > 0) { ?>
                        <td class="text-center"><strong>Total
                                <?php echo '$' . $cart->total() . ''; ?>
                            </strong></td>
                    <?php } ?>
                </tr>
            </tfoot>
        </table>
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

        <div class="footBtn">
            <a onclick="window.location.href='../ProductList/Index.php'" class="btn btn-warning"><i
                    class="glyphicon glyphicon-menu-left"></i> Seguir comprando</a>
            <a href="cartAction.php?action=placeOrder" class="btn btn-success orderBtn">Realizar pedido <i
                    class="glyphicon glyphicon-menu-right"></i></a>
        </div>


    </div>

    </div>
</body>



</html>