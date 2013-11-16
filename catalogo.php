<?php 
# Manejo de la sesión
require_once( 'app_util.php' );

/*
Obtener la accion a realizad por parte del controlador
*/
function getAccion() {
    return isset( $_GET['accion'] ) ? $_GET['accion'] : 
        ( isset( $_POST['accion'] ) ? $_POST['accion'] : null );
}

function compareAccion( $accion )
{
	return strcasecmp( $accion, getAccion() ) == 0;
}

function isLista()
{
    return compareAccion( 'lista' );
}

function isGuardar()
{
    return compareAccion( 'guardar' );
}

function isBorrar()
{
	return compareAccion( 'eliminar' );
}

function isItem()
{
	return compareAccion( 'item' );
}

function getItemId( $idKey = 'id', $array = array() )
{
	if ( count( $array ) == 0 ) 
	{
		if ( isset( $_GET[$idKey] ) ) 
		{
			$array = $_GET;
		}
		else
		{
			$array = $_POST;
		}
	}
	return $array[$idKey];
}

?>