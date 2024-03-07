<?php

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["parametro"])) {
    $parametro = $_GET["parametro"];
    return listProduct($parametro);
}

function getProducts($nombre){

include_once '../../Database/DbConection.php';    
$sql = "SELECT Id, Nombre, Cantidad, (SELECT Directorio FROM Multimediaproducto where IdProducto = a.Id limit 1)as Directorio , ValorUnitario FROM producto as a
where nombre like '%$nombre%'
 Order by Id";
$conn = conexion();
return mysqli_query($conn, $sql);
}

function listProduct($nombre){
    $resultado = getProducts($nombre);
    if ($resultado->num_rows ==0) {
        ?>
<div class="noEncontrado">

    <img class="imgNoencontrado" src="../../src/no_encontrado.jpg" alt="">
    <h3 class='titleResult'>No se encontaron datos realcionados con tu búsqueda </h3>
    <buttonc class="home" onclick="window.location.href='../ProductList/Index.php'">Volver al inicio <i
            class="fa-solid fa-house-chimney-window"></i></button>

</div>
<?php
    }else{
        ?>
<h2 class="titleResult">Resultados</h2>
<div class="containerProducts">
    <div class="products">
        <?php
                while ($fila = mysqli_fetch_assoc($resultado)) {
                  ?>
        <div class="card">
            <div class="imageProduct" onclick="window.location.href='../Product/index.php?id=<?php echo $fila['Id'] ?>'"
                style="background-image: url('<?php echo $fila["Directorio"] ?>');"></div>
            <div class="nameProduct" onclick="window.location.href='../Product/index.php?id=<?php echo $fila['Id'] ?>'">
                <?php echo $fila["Nombre"];?>
            </div>
            <div class="valueProduct">$ <?php echo number_format($fila["ValorUnitario"], 0);?></div>
            <div class="ContentAddCar">
                <button 
                    onclick="window.location.href='../CarPay/cartAction.php?action=addToCart&id=<?php echo $fila['Id'] ?>'" 
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