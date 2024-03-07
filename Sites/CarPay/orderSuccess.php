<!DOCTYPE html>
<html lang="en">

<head>
    <title>Orden exitosa</title>
    <meta charset="utf-8">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC:wght@300&family=Jost:wght@300&family=Roboto:wght@100;300&display=swap"
        rel="stylesheet" />
    <script src="https://kit.fontawesome.com/2943493a50.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../Styles/style.css" />
    <link rel="stylesheet" href="../ProductList/ProductListStyle.css" />
    <link rel="stylesheet" href="../../Utilitary/navStyle.css" />
    <style>
    .inputSearch {
        height: 42px;
    }

    .container {
        width: 100%;
        padding: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    p {
        font-size: 22px;
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
        <div id="contenido">
            <div class="container">
                <h1>Estado del pedido</h1>
                <p>Su pedido se ha enviado correctamente. El ID del pedido es #<?php echo $_GET['id']; ?></p>
                <button class="home" onclick="window.location.href='../ProductList/Index.php'">Volver al inicio <i
                        class="fa-solid fa-house-chimney-window"></i></button>
            </div>
        </div>
</body>

</html>
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
</script>