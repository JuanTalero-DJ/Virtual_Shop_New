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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="../../Utilitary/searchProduct.js" type="text/javascript"></script>
    <script src="../User/saveSearch/saveSearch.js" type="text/javascript"></script>
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
        echo listProduct("Basado en tus compras", 1);
        ?>
         <?php
        echo listProduct("Sigue buscando", 2);
        ?>
         <?php
        echo listProduct("Articulos que te puden interesar ", 3);
        ?>
    </div>
</body>

</html>
<footer>
    <div class="footer"></div>
</footer>