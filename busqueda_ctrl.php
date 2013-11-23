<?php 
require_once( 'admin.php' );
require_once( 'fd_admin.php' );

// Debe responder a una busqueda de un producto,
// Si encuentra un codigo, debe agregar una linea al arreglo de productos
// Si no encuentra el producto por su codigo debe lanzar una lista
// de resultados de tipo producto, para que se muestren en vista

$cadena = $_POST['busqueda'];
$if ( isset($cadena) ) 
{
	$buscarPorNombre = strlen( $cadena ) != 0; // No tiene sentido buscar por una cadena vacia
	$if ( !$buscarPorNombre ) 
	{
		// primero buscar el producto
		// Si se encontro
		$res = array('resultado' => true, 'actualizar' => false);
		// Añadir la linea a los tickets // Queda pendiente
		$buscarPorNombre = true; // De momento siempre buscar
	}
	
	if ( $buscarPorNombre )
	{
		// Hay que buscar por nombre y retornar el arreglo del productos
		$resultadoQuery = null; 
		$res = array('resultado' => true, 'actualizar' => true, 
			'productos' => $resultadoQuery);
	}
} else {
	$res = array('resultado' => false, 'error' => 'Paramétro incorrecto');
}

echo json_encode( $res );

?>