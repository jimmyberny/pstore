<?php 
require_once( 'admin.php' );
require_once( 'util.php' );
require_once( 'fd_admin.php' );

$accion = isset( $_POST['accion'] ) ? $_POST['accion'] : null;
if ( !is_null( $accion ) )
{
	if ( match( $accion, 'reporte')  )
	{
		$vts = reportarVentas( $_POST['inicio'], $_POST['fin'] );
		// Decorar la fecha
		for ( $vts as $v )
		{
			$vts['prettyfecha'] = date_format( date_create( $v['fecha'] ), 'Y-m-d H:i:s' );
		}
		$res = array('resultado' => true, 'ventas' = $vts);
	}
	else
	{
		$res = array( 'resultado' => false );
	}
}
else
{
	$res = array( 'resultado' => false, 'error' => 'Acción incorrecta' );
}

// Retornando el resultado
header( 'Content-Type: json' );
echo json_encode( $res );
?>