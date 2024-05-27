<?php

function validateSession()
{
    session_start();

    if (!isset($_SESSION['user'])) {
        echo '<script type="text/javascript">alert("No se encontró ninguna sesión activa, por favor ingrese nuevamente");window.location.href="../../index.html";</script>';
        exit; 
    }

        $session_timeout = 60; 
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
         session_unset();     
        session_destroy();   
        echo '<script type="text/javascript">alert("La sesión ha expirado debido a la inactividad, por favor ingrese nuevamente");window.location.href="../../index.html";</script>';
        exit; 
    }


    $_SESSION['last_activity'] = time();
}

