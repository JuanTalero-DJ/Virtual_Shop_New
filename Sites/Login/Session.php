<?php

function validateSession()
{
    session_start();
    if (!isset($_SESSION['user'])) {
        echo'<script type="text/javascript">alert("No se encontro ninguna sesión activa, por favor ingrese nuevamente");window.location.href="../../index.html";</script>';
    }

}


?>