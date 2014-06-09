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
		$ps = $con->prepare('select id, id_categoria, nombre, codigo, descripcion, existencia, minimo, venta, compra, iva, imagen from producto where codigo = :codigo');
		$ps->bindParam(':codigo', $busqueda);
		$ps->execute();
		$producto = $ps->fetch(PDO::FETCH_ASSOC);
		
		$buscarPorNombre = is_bool( $producto ); // Si es boolean SIEMPRE será un FALSE.
		if ( !$buscarPorNombre )
		{
			// Añadir el producto al ticket
			$precio = $producto['venta'];
			$impuesto = $producto['iva'] / 100;
			$precio_iva = $precio + ( $precio * $impuesto );
			// Sera un mapa donde la clave sea el id del producto
			if ( array_key_exists( $producto['id'] , $_SESSION['mapa_ticket'] ) )
			{
				// Eso de las variables por refencia es una mamada
				$fl = &$_SESSION['mapa_ticket'][ $producto['id'] ]; //['cantidad'] += 1;
				$fl['cantidad'] += 1;
				$fl['precio'] = $precio_iva;
				$fl['total'] = $fl['cantidad'] * $fl['precio'];
			}
			else
			{
				$_SESSION['mapa_ticket'][ $producto['id'] ] = array('id_linea' => 0, 
					'orden' => 0,
					'id_producto' => $producto['id'],
					'codigo' => $producto['codigo'],
					'nombre' => $producto['nombre'],
					'cantidad' => 1,
					'precio' => $precio,
					'impuesto' => $precio * $impuesto,
					'total' => $precio_iva,
					'imagen' => $producto['imagen']);
			}
			$res = array('resultado' => true, 'actualizar' => false, 'mensaje' => 'Se agrego un producto a la venta');
		}
	}
	
	if ( $buscarPorNombre )
	{
		try 
		{
			$ps = $con->prepare('select * from producto where nombre like :codigo');
			$valor = '%' . $busqueda . '%';
			$ps->bindParam(':codigo', $valor);
			$ps->execute();
			$pdts = $ps->fetchAll( PDO::FETCH_ASSOC );
			// Hay que buscar por nombre y retornar el arreglo del productos
			if ( is_bool( $pdts ) or count( $pdts ) == 0 ) 
			{
				$res = array('resultado' => false, 'error' => 'No se encontró el producto' );
			}
			else
			{
				$res = array('resultado' => true, 'actualizar' => true, 'productos' => $pdts );
			}
		}
		catch ( PDOException $ex )
		{
			$res = array('resultado' => false, 'error' => $ex->getMessage() );
		}
	}
} else {
	$res = array('resultado' => false, 'error' => 'Paramétro incorrecto');
}

header( 'Content-Type: json' );
echo json_encode( $res );

?>