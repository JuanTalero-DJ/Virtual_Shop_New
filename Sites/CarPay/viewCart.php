<?php
// initializ shopping cart class
include 'Cart.php';
$cart = new Cart;
?>
<!DOCTYPE html>

<head>
    <title>Ver carrito</title>
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
    /* .container {
        padding: 50px;
    } */

    input[type="number"] {
        width: 20%;
    }

    .inputSearch {
        height: 42px;
    }
    </style>

</head>

<body>
    <?php

include_once '../../Database/DbConection.php';    

?>
    <div class="nav">
        <?php
        include_once '../../Utilitary/nav.php';   
    ?>
    </div>
    <div id="contenido">

        <div class="container">

            <h1>Mi carrito</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th> </th>
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
                        <td><input type="number" class="form-control text-center" value="<?php echo $item["qty"]; ?>"
                                onchange="updateCartItem(this, '<?php echo $item["rowid"]; ?>')" ></td>
                        <td><?php echo '$'.$item["subtotal"].''; ?></td>
                        <td>
                            <a href="cartAction.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>"
                                class="btn btn-danger" onclick="return confirm('Estas seguro?')"><i
                                    class="glyphicon glyphicon-trash"></i></a>
                        </td>
                    </tr>
                    <?php } }else{ ?>
                    <tr>
                        <td colspan="5">
                            <p>Tu carrito esta vacío.....</p>
                        </td>
                        <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><a onclick="window.location.href='../ProductList/Index.php'" class="btn btn-warning"><i
                                    class="glyphicon glyphicon-menu-left"></i> Seguir
                                comprando</a></td>
                        <td colspan="2"></td>
                        <?php if($cart->total_items() > 0){ ?>
                        <td class="text-center"><strong>Total <?php echo '$'.$cart->total().''; ?></strong></td>
                        <td><a href="checkout.php" class="btn btn-success btn-block">Verificar <i
                                    class="glyphicon glyphicon-menu-right"></i></a></td>
                        <?php } ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>

<script>
function updateCartItem(obj, id) {
    
    $.get("cartAction.php", {
        action: "updateCartItem",
        id: id,
        qty: obj.value
    }, function(data) {
        if (data == 'ok') {
            location.reload();
        } 
        else {

            console.log(id)
            alert(data);
        }
    });
}


$(document).on("click", ".buttonSearch", function() {
    var parametro = $(".inputSearch").val();
    var xhr = new XMLHttpRequest();
    xhr.open(
        "GET",
        "../ProductList/GetProduct.php?parametro=" + parametro,
        true
    );
    xhr.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var respuesta = xhr.responseText;
            console.log(respuesta);
            $("#contenido").empty();
            $("#contenido").append(respuesta);
        }
    };
    var parametros = "parametro=" + parametro;
    xhr.send(parametros);
});
</script>