<!DOCTYPE html>
<html lang="en">
  <!-- <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="navStyle.css" />
    <link rel="stylesheet" href="../Sites/ProductList/index.php" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC:wght@300&family=Jost:wght@300&family=Roboto:wght@100;300&display=swap"
      rel="stylesheet"
    />
    <script
      src="https://kit.fontawesome.com/2943493a50.js"
      crossorigin="anonymous"
    ></script>
   
    <title>Document</title>
  </head> -->
  <body>
    <ul>
      <div class="logo"></div>

      <div class="search">
        <input
          id="inputSearch"
          class="inputSearch"
          type="text"
          placeholder="Escribe lo que buscas"
        />
        <button id="buttonSearch" class="buttonSearch">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </div>
      <div class="options">
        <li>
          <a onclick="window.location.href='../CarPay/viewCart.php'">Carrito <i class="fa-solid fa-cart-shopping"></i></a>
        </li>
        <li>
          <a onclick="window.location.href='../Login/DestroydSession.php'"> <?php echo $_SESSION['user']['NombreCliente'] ?> <i class="fa-solid fa-circle-user"></i></a>
        </li>
      </div>
    </ul>
  </body>


</html>
