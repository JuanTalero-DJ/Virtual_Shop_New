<?php
include 'Cart.php';
$cart = new Cart;

include_once '../../DataBase/DbConection.php';
$db = conexion();

if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){
        $productID = $_REQUEST['id'];
        $query = $db->query("SELECT * FROM producto WHERE idProducto = ".$productID);
        $row = $query->fetch_assoc();
        $itemData = array(
            'id' => $row['IdProducto'],
            'name' => $row['Nombre'],
            'price' => $row['ValorUnitario'],
            'qty' => 1
        );
        $insertItem = $cart->insert($itemData);
        $mensaje = $insertItem? "Se añadiò el producto al carrito, para finalizar la compra ve a CARRITO":"No se añadio el producto, vereifique su sesión o intentelo mas tarde ";
        echo'<script type="text/javascript">alert("'.$mensaje.'");window.location.href="../ProductList/index.php";</script>';

    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){

        $err="";
        $cartItem = $cart->get_item($_REQUEST['id']);
        $productID = $cartItem['id'];
        $quantity = $cartItem['qty'];
        $query= $db->query("SELECT * FROM Producto WHERE IdProducto = ".$productID);
        $row = $query->fetch_assoc();
        
        if(intval($quantity) > intval($row['Cantidad'])){
            echo 'Lo sentimos, la cantidad solicitada del producto '. $row['Nombre'] . ' supéra la disponibilidad. Cambia la cantidad en el carrito e intenta de nuevo';
        }

        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'qty' => $_REQUEST['qty']
        );
        $updateItem = $cart->update($itemData);

        
        
        echo $updateItem?'ok':$err;
        die;
    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){
        $deleteItem = $cart->remove($_REQUEST['id']);
        header("Location: viewCart.php");
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0 && !empty($_SESSION['user']['IdCliente'])){

        $cartItems = $cart->contents();
        foreach($cartItems as $item){
            $query= $db->query("SELECT (a.Cantidad- SUM(b.Cantidad)) as Cantidad, a.Nombre FROM producto as a 
             Join itemPedido as b on a.IdProducto = b.IdProducto 
             Join pedido as c on b.idpedido = c.idpedido 
             WHERE a.IdProducto = ".$item['id']." and c.Estado = '1'"
            );
            $row = $query->fetch_assoc();

            if($item['qty'] > $row['Cantidad']){
                $msj ='Los sentimos, la cantidad solicitada del producto '. $row['Nombre'] . ' supéra la disponibilidad. Cambia la cantidad en el carrito e intenta de nuevo';
                ?>
                    <script>
                        alert("<?php echo $msj ?>");
                        window.location.href="viewCart.php"
                    </script>
                <?php
                return;
            }
        }
        
        $insertOrder = $db->query("INSERT INTO pedido ( IdCliente,FechaPedido, FechaEntrega,Estado, Total) VALUES ('".$_SESSION['user']['IdCliente']."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','1','".$cart->total()."')");
        
        if($insertOrder){
            $orderID = $db->insert_id;
            $querys = '';
            // get cart items
            $cartItems = $cart->contents();
            foreach($cartItems as $item){

                $query= $db->query("SELECT * FROM producto WHERE idproducto = ".$item['id']);
                $row = $query->fetch_assoc();
                $querys .= "INSERT INTO itempedido (IdPedido, IdProducto, SubTotal, Cantidad) VALUES ('".$orderID."','".$item['id']."','".($item['qty']*$row['ValorUnitario'])."','".$item['qty']."');";
                $actualAviable = intval($row['Cantidad'])- intval($item['qty']);


            }
            // insert order items into database and update data
    
            $insertOrderItems = $db->multi_query($querys);
            
            if($insertOrderItems){
                $cart->destroy();
                header("Location: orderSuccess.php?id=$orderID");
            }else{
                header("Location: checkout.php");
            }
        }else{
            header("Location: checkout.php");
        }
    }else{
        header('Location:../ProductList/index.php');
    }
}else{
    header('Location:../ProductList/index.php');
}