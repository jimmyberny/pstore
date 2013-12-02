<?php 
require_once( 'admin.php' ); // Abre la sesion

require_once( 'util.php' ); // Utils
require_once( 'fd_admin.php' ); // Acceso a la base de datos

// En un post deben venir que quieren que haga
// Esta es la acción
$accion = isset( $_GET['accion']) ? $_GET['accion'] :
	( isset( $_POST['accion'] ) ? $_POST['accion'] : null );
// Aqui se guarda el resultado
$res = array();

if ( isset( $accion ) )
{
	if ( match( 'vender', $accion ) ) 
	{
		$res['query'] = 'Se puede vender';
		$res['resultado'] = isset( $_SESSION['mapa_ticket'] ) and count( $_SESSION['mapa_ticket'] ) != 0;
		if ( $res['resultado'] ) {
			$total = 0;
			foreach ($_SESSION['mapa_ticket'] as $k => $v) 
			{
				$total += $v['total'];
			}
			$res['total'] = $total;
		}

	}
	else if ( match( 'listar', $accion ) )
	{
		// id_linea, orden, id_producto, nombre, cantidad, precio, impuesto, total
		$lineas = array();
		$total = 0;
		foreach ($_SESSION['mapa_ticket'] as $k => $v) 
		{
			$lineas[] = $v;
			$total += $v['total'];
		}

		// Pack res
		$res['resultado'] = true; // Correcto
		$res['total'] = $total;
		$res['lineas'] = $lineas;
		$res['fecha'] = date('Y-m-s h:m:s');
	}
	else if ( match( 'guardar', $accion ) )
	{
		$lineas = array();
		$total = 0;
		foreach ($_SESSION['mapa_ticket'] as $k => $v) 
		{
			$lineas[] = $v;
			$total += $v['total'];
		}

		// Mandaron el total recibido $_POST['recibido']
		$ticket = array('id_caja' => $_SESSION['caja']['id'],
			'id_usuario' => $_SESSION['usuario']['id'],
			'id_cliente' => null );
		$pago = array('importe' => $total, 'recibido' => $_POST['recibido']);

		$res = guardarTicket($ticket, $pago, $lineas);
		if ( $res['resultado'] )
		{ // Se guardo correctamente
			$_SESSION['mapa_ticket'] = array(); // Nuevo ticket
		}
	}
	//
} else {
	// 
	$res = array('resultado' => false, 'error' => 'Acción incorrecta');
}

// Retornando el resultado
header( 'Content-Type: json' );
echo json_encode( $res );
?>