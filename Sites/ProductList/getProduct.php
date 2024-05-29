<?php

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["parametro"])) {
    $parametro = $_GET["parametro"];
    return listProductSearch($parametro);
}


function getProducts($nombre, $tipo)
{
    $result = '';
    $findproduct = true;
    include_once '../../Database/DbConection.php';

    switch ($tipo) {
        case 1: // Productos previamnete comprados 
            $idCliente = $_SESSION['user']['IdCliente'];
            $sql = "SELECT distinct c.IdProducto, c.Nombre, c.Cantidad, (SELECT Url FROM Multimediaproducto where IdProducto = c.IdProducto limit 1)as url , c.ValorUnitario FROM pedido as a
                join itempedido as b on a.IdPedido = b.IdPedido
                inner join producto as c on b.idProducto = c.IdProducto
                where a.idCliente = $idCliente
                Order by b.IdProducto";
            $conn = conexion();
            $result = mysqli_query($conn, $sql);

            break;

        case 2:
            $idCliente = $_SESSION['user']['IdCliente'];
            $sql = "SELECT b.IdProducto, b.Nombre, b.Cantidad, (SELECT Url FROM Multimediaproducto where IdProducto = b.IdProducto limit 1)as url , b.ValorUnitario FROM busquedascliente as a
                join producto as b  on a.IdCategoria = b.IdCategoria or CONCAT('%',a.Palabraclave ,'%') 
                where a.idCliente = $idCliente
                Order by b.IdProducto";
            $conn = conexion();
            $result = mysqli_query($conn, $sql);
            break;

        default:

            $sql = "SELECT IdProducto, Nombre, Cantidad, (SELECT Url FROM Multimediaproducto where IdProducto = a.IdProducto limit 1)as url , ValorUnitario FROM producto as a
            where Nombre like '%$nombre%'
            Order by IdProducto";
            $conn = conexion();
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows == 0) {
                $findproduct = false;
                $sql = "SELECT b.IdProducto, b.Nombre, b.Cantidad, (SELECT Url FROM Multimediaproducto where IdProducto = b.IdProducto limit 1)as url , b.ValorUnitario FROM palabrasclaves as a
                join producto as b on a.IdCategoria = b.IdCategoria
                where a.PalabrasClave like '%$nombre%'
                Order by b.IdProducto";
                $conn = conexion();
                $result = mysqli_query($conn, $sql);
            }
            break;
    }

    return [$findproduct, $result];
}

function listProduct($nombreseccion, $tipo)
{
    $resultado = getProducts("", $tipo);

    if ($resultado[1]->num_rows == 0) {
        $nombreseccion = "";
    }


    ?>
    <h2 class="titleResult"><?php echo $nombreseccion ?></h2>
    <div class="containerProducts">
        <div class="products">
            <?php
            while ($fila = mysqli_fetch_assoc($resultado[1])) {
                ?>
                <div class="carousel-container">
                    <div class="carousel-slide">
                        <div class="card">
                            <div class="imageProduct"
                                onclick="window.location.href='../Product/index.php?id=<?php echo $fila['IdProducto'] ?>'"
                                style="background-image: url('<?php echo $fila["url"] ?>');"></div>
                            <div class="nameProduct"
                                onclick="window.location.href='../Product/index.php?id=<?php echo $fila['IdProducto'] ?>'">
                                <?php echo $fila["Nombre"]; ?>
                            </div>
                            <div class="valueProduct">$ <?php echo number_format($fila["ValorUnitario"], 0); ?></div>
                            <div class="ContentAddCar">
                                <button
                                    onclick="window.location.href='../CarPay/cartAction.php?action=addToCart&id=<?php echo $fila['IdProducto'] ?>'"
                                    class="addCar">
                                    Añadir al carrito <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}

function listProductSearch($nombre)
{

    $resultado = getProducts($nombre, 3);
    if ($resultado[0] == false) {

        ?>
        <div class="noEncontrado">

            <img class="imgNoencontrado" src="../../src/no_encontrado.jpg" alt="">
            <h3 class='titleResult'>No se encontaron datos realcionados con tu búsqueda </h3>
            <buttonc class="home" onclick="window.location.href='../ProductList/Index.php'">Volver al inicio <i
                    class="fa-solid fa-house-chimney-window"></i></button>

        </div>
        <?php
    }
    if ($resultado[1]->num_rows > 0) {

        ?>
        <h2 class="titleResult">Productos que te pueden interesar</h2>
        <div class="containerProducts">
            <div class="products">
                <?php
                while ($fila = mysqli_fetch_assoc($resultado[1])) {
                    ?>
                    <div class="card">
                        <div class="imageProduct"
                            onclick="window.location.href='../Product/index.php?id=<?php echo $fila['IdProducto'] ?>'"
                            style="background-image: url('<?php echo $fila["url"] ?>');"></div>
                        <div class="nameProduct"
                            onclick="window.location.href='../Product/index.php?id=<?php echo $fila['IdProducto'] ?>'">
                            <?php echo $fila["Nombre"]; ?>
                        </div>
                        <div class="valueProduct">$ <?php echo number_format($fila["ValorUnitario"], 0); ?></div>
                        <div class="ContentAddCar">
                            <button
                                onclick="window.location.href='../CarPay/cartAction.php?action=addToCart&id=<?php echo $fila['IdProducto'] ?>'"
                                class="addCar">
                                Añadir al carrito <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }
}

?>