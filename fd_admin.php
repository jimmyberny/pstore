<?php 
# Fuente de datos para usuarios
require_once( 'db_util.php' );

$tbl_usuario = array(
	'name' => 'usuario',
	'fields' => array('id', 'nombre', 'paterno', 'materno', 'usuario', 'contra', 'id_rol'),
	'form' => array(
		'usuario' => 'nusuario', 
		'contra' => 'contrasena',
		'id_rol' => 'rol'),
	'ids' => array(0),
	'order' => array(1, 2, 3)
	);

$t_rol = array(
		'name' => 'rol',
		'fields' => array('id', 'nombre', 'tipo', 'inicio'),
		'form' => array(),
		'ids' => array(0),
		'order' => array(1)
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
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		error_log('Must update object');
		return doUpdate( $tbl_usuario, $datos );
	}
	error_log('Insert object');
	return doInsert( $tbl_usuario, $datos );
}

function borrarUsuario( $datos )
{
	global $tbl_usuario;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doDelete( $tbl_usuario, $datos );
	}
	return array('resultado' => false, 'error' => 'Identificador para usuario incorrecto.');
}

function getUsuario( $idUsuario ) 
{
	global $tbl_usuario;
	return doQueryById( $tbl_usuario, array('id' => $idUsuario) );
}

function listarRoles()
{
	global $t_rol;
	try {
		return array( 'roles' => doQuery( getSelect( $t_rol ) ) );
	}
	catch ( PDOException $ex )
	{
		return array( 'roles' => array(), 'error' => $ex->getMessage() );
	}
}

function guardarRol ( $data )
{
	global $t_rol;
	if ( isset( $data['id'] ) and strlen( $data['id'] ) != 0 )
	{
		return doUpdate( $t_rol, $data );
	}
	return doInsert( $t_rol, $data );
}

function borrarRol ( $data )
{
	global $t_rol;
	if ( isset( $data['id'] ) and strlen( $data['id'] ) != 0 )
	{
		return doDelete( $t_rol, $data );
	}
	return array('resultado' => false, 'error' => 'Identificador incorrecto' );
}

function getRol ( $id )
{
	global $t_rol;
	return doQueryById( $t_rol, array('id' => $id ) );
}
?>