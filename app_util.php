<?php
# Utilidades de la aplicacion 

function show_app_error( $exception ) 
{
    echo "Error: " . $exception->getMessage();
}
?>