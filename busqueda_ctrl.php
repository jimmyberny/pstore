<?php 
require_once( 'admin.php' );
require_once( 'db_util.php');

// Debe responder a una busqueda de un producto,
// Si encuentra un codigo, debe agregar una linea al arreglo de productos
// Si no encuentra el producto por su codigo debe lanzar una lista
// de resultados de tipo producto, para que se muestren en vista

$busqueda = $_POST['busqueda'];
if ( isset($busqueda) ) 
{
	$buscarPorNombre = strlen( $busqueda ) == 0; // No tiene sentido buscar por una cadena vacia
	if ( !$buscarPorNombre ) 
	{
		$ps = $con->prepare('select id, id_categoria, nombre, codigo, descripcion, existencia, minimo, venta, compra, iva from producto where codigo = :codigo');
		$ps->bindParam(':codigo', $busqueda);
		$ps->execute();
		$producto = $ps->fetch(PDO::FETCH_ASSOC);
		
		$buscarPorNombre = is_bool( $producto ); // Si es boolean SIEMPRE será un FALSE.
		if ( !$buscarPorNombre )
		{
			// Añadir el producto al ticket
			if ( !isset( $_SESSION['lineas_ticket'] ) ) {
				$_SESSION['lineas_ticket'] = array();
			}
			$precio = $producto['venta'];
			$impuesto = $producto['iva'] / 100;
			$precio_iva = $precio + ( $precio * $impuesto );
			$_SESSION['lineas_ticket'][] = array('id_linea' => 0, 
				'orden' => 0,
				'id_producto' => $producto['id'],
				'nombre' => $producto['nombre'],
				'cantidad' => 1,
				'precio' => $precio,
				'impuesto' => $precio * $impuesto,
				'total' => $precio_iva, );
			$res = array('resultado' => true, 'actualizar' => false, 'mensaje' => 'Se agrego un producto a la venta');
		}
	}
	
	if ( $buscarPorNombre )
	{
		$ps = $con->prepare('select * from producto where nombre like :codigo');
		$valor = '%' . $busqueda . '%';
		$ps->bindParam(':codigo', $valor);
		$ps->execute();
		$productos= $ps->fetchAll(PDO::FETCH_ASSOC);
		// Hay que buscar por nombre y retornar el arreglo del productos
		$res = array('resultado' => true, 'actualizar' => true, 
			'productos' => $productos);
	}
} else {
	$res = array('resultado' => false, 'error' => 'Paramétro incorrecto');
}

header( 'Content-Type: json' );
echo json_encode( $res );

?>