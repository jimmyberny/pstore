<?php 
require_once( 'admin.php' );
require_once( 'fd_admin.php' );
require_once( 'db_util.php');

// Debe responder a una busqueda de un producto,
// Si encuentra un codigo, debe agregar una linea al arreglo de productos
// Si no encuentra el producto por su codigo debe lanzar una lista
// de resultados de tipo producto, para que se muestren en vista

$busqueda = $_POST['busqueda'];
if ( isset($busqueda) ) 
{
	$buscarPorNombre = strlen( $busqueda ) != 0; // No tiene sentido buscar por una cadena vacia
	if ( !$buscarPorNombre ) 
	{
		$ps = $con->prepare('select * from producto where codigo = :codigo');
		$ps->bindParam(':codigo', $busqueda);
		$ps->execute();
		$encontrado = $ps->fetch(PDO::FETCH_ASSOC);
		
		$res = array('resultado' => true, 'actualizar' => false);
		// Añadir la linea a los tickets // Queda pendiente
		$buscarPorNombre = !$encontrado; // De momento siempre buscar
	}
	
	if ( $buscarPorNombre )
	{
		$ps = $con->prepare('select * from producto where nombre like :codigo');
		$ps->bindParam(':codigo', '%'.$busqueda.'%');
		$ps->execute();
		$productos= $ps->fetchAll(PDO::FETCH_ASSOC);
		// Hay que buscar por nombre y retornar el arreglo del productos
		$res = array('resultado' => true, 'actualizar' => true, 
			'productos' => $productos);
	}
} else {
	$res = array('resultado' => false, 'error' => 'Paramétro incorrecto');
}

echo json_encode( $res );

?>