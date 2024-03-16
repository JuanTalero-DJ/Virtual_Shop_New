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
    <link
    href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    rel="stylesheet"
    id="bootstrap-css"
    />
    <link rel="stylesheet" href="UserStyle.css" />
    <link rel="stylesheet" href="../../Styles/style.css" />
    <link rel="stylesheet" href="../../Utilitary/navStyle.css" />
    <link rel="stylesheet" href="../ProductList/ProductListStyle.css" />
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/2943493a50.js" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <title>Mi información</title>

    <style>
 
    .nav{
      display:block;
    }

    .main{
      display: flex;
      justify-content: center;
    }

    </style>
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

    <div id="contenido">
    <div class="lefthome" onclick="window.location.href='../ProductList/Index.php'"> <i
                class="fa-solid fa-arrow-left"></i> Volver al inicio</div>
        <?php
        
        include_once '../../Database/DbConection.php';    
            
        $idCliente = $_SESSION['user']['IdCliente'];
        $find = "SELECT * FROM Cliente WHERE IdCliente = $idCliente ";
        $conn = conexion();
        $resultado = mysqli_query($conn, $find);
        $data = mysqli_fetch_assoc($resultado);
          
    ?>
    <div class="main">
      <div class="formUser">
        <h3>Mi información</h3>
        <form method="post" action="editUser.php">
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="">Tipo de identificación </label><br />
                <select name="TipoIdentificacion" id="TipoIdentificacion" required disabled>
                  <option value="">Seleccione</option>
                  <option value="NIT">Nit</option>
                  <option value="CC">Cédula de ciudadania</option>
                  <option value="CE">Cédula de extrangería</option>
                  
                </select>
                
              </div>
            </div>
            <div class="col-md">
              <div class="form-group">
                <label for="">Número de identificación</label><br />
                <input
                  name="NumIdentifiacion"
                  maxlength="10"
                  type="text"
                  placeholder="Número de identificación"
                  value="<?php echo $data["NumIdentifiacion"] ?>"
                  required
                  disabled
                />
              </div>
            </div>

            <div class="col-md">
              <div class="form-group">
                <label for="">Nombre Completo </label><br />
                <input
                  name="Nombre"
                  type="text"
                  placeholder="Nombre"
                  value="<?php echo $data["NombreCliente"] ?>"
                  required
                  disabled
                />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="">Teléfono 1</label><br />
                <input
                  name="Telefono1"
                  maxlength="10"
                  type="text"
                  placeholder="Teléfono 1"
                  value="<?php echo $data["NumTelefonico1"] ?>"
                  required
                />
              </div>
            </div>

            <div class="col-md">
              <div class="form-group">
                <label for="">Teléfono 2</label><br />
                <input
                  name="Telefono2"
                  type="text"
                  placeholder="Teléfono 2"
                  value="<?php echo $data["NumTelefonico2"] ?>"
                  required
                />
              </div>
            </div>
            <div class="col-md"></div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="">Dirección</label><br />
                <input
                  name="Direccion"
                  maxlength="50"
                  type="text"
                  placeholder="Dirección"
                  value="<?php echo $data["NumTelefonico1"] ?>"
                  required
                />
              </div>
            </div>

            <div class="col-md">
              <div class="form-group">
                <label for="">Código Postal </label><br />
                <input
                  name="CodigoPostal"
                  type="number"
                  placeholder="Código Postal"
                  value="<?php echo $data["CodigoPostal"] ?>"
                  required
                />
              </div>
            </div>
            <div class="col-md"></div>
          </div>

          <div class="row">
            <div class="col-md">
              <div class="form-group">
                <label for="">Correo</label><br />
                <input
                  name="Correo"
                  type="email"
                  placeholder="Email"
                  value="<?php echo $data["Email"] ?>"
                  required
                />
              </div>
            </div>

            <div class="col-md">
              <div class="form-group">
                <label for="">Nueva Clave</label><br />
                <input
                  name="Clave"
                  type="password"
                  placeholder="Clave"
                  class = "clave"
                />
              </div>
            </div>

            <div class="col-md">
              <div class="form-group">
                <label for="">Confirmar Nueva Clave</label><br />
                <input
                  name="ConfirmarClave"
                  type="password"
                  placeholder="Confirmar Clave"
                  class = "clave"
                  
                />
              </div>
            </div>
          </div>
          <div class="row" style="text-align:center">
            
            <div class="col-md">
              <button class="create"><i class="fa-solid fa-floppy-disk"></i>  Guardar </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    
</body>

</html>

<script>
  $(".search").hide()
  $(".options").hide()
  $("#TipoIdentificacion").val("<?php echo $data["TipoIdentificacion"] ?>")

  $(document).on('change', '.clave', function() {
   if($(this).val() == "" ){
     $(".clave").attr("required", false)
  }else{
     $(".clave").attr("required", true)
   }
  });
</script>

<footer>
    <div class="footer"></div>
</footer>