<?php 
require_once( 'admin.php' ); // Seguridad
require_once( 'util.php' ); // Utilidades
require_once( 'fd_admin.php' ); // Acceso

// Controlador del corte de caja
$accion = isset( $_POST['accion'] ) ? $_POST['accion'] : null;
if ( $accion != null )
{
	// 
	if ( match( $accion, 'consultar' ) )
	{
		$caja = $_SESSION['caja']['id'];
		// resultado, inicio, fin, total
		$res = listarCaja( $caja );
		$res['inicio'] = date_format( date_create( $res['inicio'] ), 'Y-m-d H:i:s' );
		if ( !is_null( $res['fin'] ) )
		{
			$res['fin'] = date_format( date_create( $res['fin'] ), 'Y-m-d H:i:s' );
		}
		$v = 0 + $res['ventas']; // Convertir a numero la porquería de String
		$res['cerrar'] = is_null( $res['fin'] ) && ( $v > 0 );
	}
	else if ( match( $accion, 'cerrar' ) ) 
	{
		$res = cerrarCaja( $caja );
		if ( $res['resultado'] ) // Se cerro la caja de forma correcta
		{
			// Actualizar el id de la nueva caja
			$_SESSION['caja']['id'] = $res['caja'];
			//
			$res['fin'] = date_format( date_create($res['fin']), 'Y-m-d H:i:s' );
		}
	}
	else
	{
		$res = array( 'resultado' => false, 'error' => 'Accion incorrecta.' );
	}
}
else
{
	$res = array( 'resultado' => false, 'error' => 'Acción incorrecta.' );
}

// Retornando el resultado
header( 'Content-Type: json' );
echo json_encode( $res );
?>