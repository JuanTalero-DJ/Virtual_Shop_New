<?php
include 'Cart.php';
$cart = new Cart;

include_once '../../DataBase/DbConection.php';
$db = conexion();

if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){
        $productID = $_REQUEST['id'];
        $query = $db->query("SELECT * FROM producto WHERE id = ".$productID);
        $row = $query->fetch_assoc();
        $itemData = array(
            'id' => $row['ID'],
            'name' => $row['Nombre'],
            'price' => $row['ValorUnitario'],
            'qty' => 1
        );
        $insertItem = $cart->insert($itemData);
        $mensaje = $insertItem? "Se añadiò el producto al carrito, para finalizar la compra ve a CARRITO":"No se añadio el prodcuto, vereifique su sesión o intentelo mas tarde ";
        echo'<script type="text/javascript">alert("'.$mensaje.'");window.location.href="../ProductList/index.php";</script>';

    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){

        $err="";
        $cartItem = $cart->get_item($_REQUEST['id']);
        $productID = $cartItem['id'];
        $quantity = $cartItem['qty'];
        $query= $db->query("SELECT * FROM Producto WHERE IdProducto = ".$productID);
        $row = $query->fetch_assoc();
        
        if(intval($quantity) > intval($row['Cantidad'])){
            echo 'Los sentimos, la cantidad solicitada del producto '. $row['Nombre'] . ' supéra la disponibilidad. Cambia la cantidad en el carrito e intenta de nuevo';
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
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0 && !empty($_SESSION['user']['ID'])){

        $cartItems = $cart->contents();
        foreach($cartItems as $item){
            $query= $db->query("SELECT * FROM producto WHERE id = ".$item['id']);
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
        
        $insertOrder = $db->query("INSERT INTO pedido ( IdCliente,FechaPedido, FechaEntrega,Estado, Total) VALUES ('".$_SESSION['user']['IdCliente']."','".date("Y-m-d H:i:s")."',,'212121121' '1', '".$cart->total()."')");
        
        if($insertOrder){
            $orderID = $db->insert_id;
            $querys = '';
            // get cart items
            $cartItems = $cart->contents();
            foreach($cartItems as $item){

                $query= $db->query("SELECT * FROM producto WHERE id = ".$item['id']);
                $row = $query->fetch_assoc();
                $querys .= "INSERT INTO Item_venta (Idventa, Cantidad, IdProducto) VALUES ('".$orderID."', '".$item['qty']."', '".$item['id']."');";
                $actualAviable = intval($row['Cantidad'])- intval($item['qty']);
                // $querys .="UPDATE Producto SET Cantidad = " . $actualAviable . " WHERE ID = '" . $item['id'] . "';";
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