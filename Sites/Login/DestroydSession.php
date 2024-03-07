<?php
    session_start();
    session_destroy();
    // echo '<script type="text/javascript">alert("Se cerró la sesion correctamente, ¡lo esperamos pronto! ");window.location.href="../../index.html";</script>';
    header('Location:../../index.html');
    exit;

?>