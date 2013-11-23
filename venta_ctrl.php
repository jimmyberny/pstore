<?php 
require_once( 'admin.php' );

function match( $cad, $cad2 ) 
{
	return strcasecmp( $cad, $cad2 ) == 0; // Son iguales
}
// En un post deben venir que quieren que haga
// Esta es la acción
$accion = isset( $_GET['accion']) ? $_GET['accion'] :
	( isset( $_POST['accion'] ) ? $_POST['accion'] : null );
// Aqui se guarda el resultado
$res = null;

if ( isset( $accion ) )
{
	if ( match( 'vender', $accion) ) 
	{

	}
	else if ( match( 'listar', $accion ) )
	{
		// id_linea, orden, id_producto, nombre, cantidad, precio, impuesto
		$lineas = $_SESSION['lineas_ticket'];
		$res['resultado'] = true;
		$res['lineas'] = $lineas;
	}
	//
} else {
	// 
	$res = array('resultado' => false, 'error' => 'Acción incorrecta');
}

// Retornando el resultado
echo json_encode( $res );
?>