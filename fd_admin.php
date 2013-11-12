<?php 
# Fuente de datos para usuarios
require_once( 'db_util.php' );

$tbl_usuario = array(
	'name' => 'usuario',
	'fields' => array('id', 'nombre', 'paterno', 'materno', 'usuario', 'contra'),
	'form' => array(
		'usuario' => 'nusuario', 
		'contra' => 'contrasena'),
	'ids' => array(0),
	'order' => array(1, 2, 3)
	);

# sayHi( 'pollo' );

# echo "Call method";
# echo json_encode( listarUsuario() );

function listarUsuarios()
{
	global $tbl_usuario;
	try 
	{
		$rs = doQuery( getSelect( $tbl_usuario ) );
		# var_dump( $rs );
		return array( 'usuarios' => $rs );
	} 
	catch ( PDOException $ex ) 
	{
		show_app_error( $ex );
		die();
	}
}

function guardarUsuario( $datos )
{
	global $tbl_usuario;
	if ( isset( $datos['id']) and strlen($datos['id']) != 0 )
	{
		error_log('Must update object');
		return doUpdate( $tbl_usuario, $datos );
	}
	return doInsert( $tbl_usuario, $datos );
}

function getUsuario( $idUsuario ) 
{
	global $tbl_usuario;
	return doQueryById( $tbl_usuario, array('id' => $idUsuario) );
}

?>