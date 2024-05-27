<!DOCTYPE html>
<html lang="en">

<body>
  <ul>
    <div class="logo"></div>

    <div class="search">
      <input id="inputSearch" class="inputSearch" type="text" placeholder="Escribe lo que buscas" />
      <button id="buttonSearch" class="buttonSearch">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>
    </div>
    <div class="options">
      <li class='option'>
        <a onclick="window.location.href='../CarPay/viewCart.php'">Carrito
          <i class="fa-solid fa-cart-shopping"></i></a>
      </li>
      <li class='option'>
        <a> <?php echo $_SESSION['user']['NombreCliente'] ?> <i class="fa-solid fa-circle-user"></i></a>
        <ul class="ulSubOptions">
          <li class="SubOptions"><a onclick="window.location.href='../User/viewEditUser.php'">Mi información</a></li>
          <li class="SubOptions"><a href="">Mis pedidos</a></li>
          <li class="SubOptions"><a onclick="window.location.href='../Login/DestroydSession.php'">Salir</a></li>
        </ul>
      </li>


    </div>
  </ul>
</body>


</html>