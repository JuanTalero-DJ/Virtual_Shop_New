<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC:wght@300&family=Jost:wght@300&family=Roboto:wght@100;300&display=swap"
        rel="stylesheet" />
    <script src="https://kit.fontawesome.com/2943493a50.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../Styles/style.css" />
    <link rel="stylesheet" href="ProductStyle.css" />
    <link rel="stylesheet" href="../ProductList/ProductListStyle.css" />
    <link rel="stylesheet" href="../../Utilitary/navStyle.css" />
    <title>Productos</title>
</head>

<body>
<?php
        include_once '../Login/Session.php';
        validateSession();
    ?>
<div class="nav">
    <?php
        include_once '../../Utilitary/nav.php';   
    ?>
</div>
    <?php

            include_once '../../Database/DbConection.php';    
            
            $id = $_GET['id'];
            $find = "SELECT Id, Nombre, Cantidad, Directorio , ValorUnitario, Descripcion FROM producto as a 
            JOIN MultimediaProducto as b on a.id = b.idProducto
            WHERE Id =$id limit 1";
            $conn = conexion();
            $resultado = mysqli_query($conn, $find);
            $data = mysqli_fetch_assoc($resultado);


            $find = "SELECT  Directorio FROM MultimediaProducto
            WHERE IdProducto =$id";
            $conn = conexion();
            $imagenes = mysqli_query($conn, $find);
            
    ?>
    <div id="contenido">
        <div class="lefthome" onclick="window.location.href='../ProductList/Index.php'"> <i
                class="fa-solid fa-arrow-left"></i> Volver al inicio</div>
        <div class="containerProduct">
            <div class="contentProduct">
                <div class="nameProductBig">
                    <h2><?php echo $data["Nombre"] ?></h2>
                </div>
                <div class="imageProductBig" style="background-image: url('<?php echo $data["Directorio"] ?>');"></div>
                <div class="descriptionProdcut">

                    <h3>Descripción</h3>
                    <p><?php echo $data["Descripcion"] ?></p>
                    <p class="price">$ <?php echo number_format($data["ValorUnitario"], 0);?></p>
                    <p class="available">Cantidad disponible <?php echo $data["Cantidad"] ?></p>
                </div>

                <div class="slider">
                    <?php
                while ($fila = mysqli_fetch_assoc($imagenes)) {
                  ?>
                    <div class="imageSlider" style="background-image: url('<?php echo $fila["Directorio"] ?>');">
                    </div>
                    <?php
                }
                ?>


                </div>

                <div class="contentAddCarBig"><button
                        onclick="window.location.href='../CarPay/Index.php?id=<?php echo $data['Id'] ?>'"
                        class="addCar">
                        Añadir al carrito <i class="fa-solid fa-cart-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
</body>


</html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>

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

$(".imageSlider")
    .hover(function() {

            let element = $(this);
            let newImge = element[0].style.backgroundImage;
            $(".imageProductBig")[0].style.backgroundImage = newImge;
            $(this).css("transform", "translateY(-9px)");
            $(this).css("transition", "transform .6s,opacity .6s");

        }, function() {
            $(this).css("transform", "translateY(0)");
            $(this).css("transition", "");
        }

    );
</script>