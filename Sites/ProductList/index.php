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
    <link rel="stylesheet" href="ProductListStyle.css" />
    <link rel="stylesheet" href="../../Styles/style.css" />
    <link rel="stylesheet" href="../../Utilitary/navStyle.css" />
    <title>Productos</title>
</head>

<body>
    <?php
        include_once 'GetProduct.php';
        include_once '../Login/Session.php';
        validateSession();
    ?>
    <div class="nav">
        <?php
        include_once '../../Utilitary/nav.php';   
    ?>
    </div>


    <div id="contenido">
        <?php
          echo listProduct("");
    ?>
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
        "GetProduct.php?parametro=" + parametro,
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

<footer>
    <div class="footer"></div>
</footer>