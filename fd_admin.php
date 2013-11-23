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

$tbl_categoria = array('name' =>'categoria' ,
		'fields' => array('id', 'nombre'),
		'form' => array(),
		'ids' => array(0),
		'order' => array(1)	
	 );

$tbl_producto=array('name'=>'producto' ,
		'fields'=>array('id','id_categoria','nombre','codigo','descripcion','existencia','minimo','venta','compra','iva'),
		'form' => array(
			'id_categoria'=>'categoria'),
		'ids' => array(0),
		'order' => array(2,3)
	);

$tbl_cliente=array('name'=>'cliente',
		'fields'=>array('id','rfc','nombre','paterno','materno','proveedor','calle','interior','exterior','colonia','ciudad','estado'),
		'form'=>array(),
		'ids'=>array(0),
		'order'=>array(1)
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

function listarCategoria(){
	global $tbl_categoria;
	try {
		return array('categorias'=> doQuery(getSelect($tbl_categoria)));
	} catch (PDOException $ex) {
		return array('categorias' => array(),'error'=> $ex->getMessage() );
	}
}

function guardarCategoria($datos)
{
	global $tbl_categoria;
	if(isset($datos['id']) and strlen($datos['id']) != 0 )
	{
		error_log('Mustt update object');
		return doUpdate($tbl_categoria,$datos);
	}
	error_log('Isert Object');
	return doInsert($tbl_categoria,$datos);
}

function borrarCategoria($datos)
{
	global $tbl_categoria;
	if( isset($datos['id']) and strlen($datos['id']) != 0 )
	{
		return doDelete($tbl_categoria,$datos);
	}
	return array('resultado'=>false,'error'=>'Identificador para categoria incorrecto');
}

function getCategoria($idCategoria)
{
	global $tbl_categoria;
	return doQueryById($tbl_categoria,array('id'=>$idCategoria));
}
function listarProducto(){
	global $tbl_producto;
	try {
		$rs=doQuery(getSelect($tbl_producto));
		return array('producto'=>$rs );
	} catch (PDOException $ex) {
		show_app_error($ex)	;
		die();
	}
}

function guardarProducto($datos)
{
	global $tbl_producto;
	if(isset($datos['id']) and strlen($datos['id']) != 0 )
	{
		error_log('Mustt update object');
		return doUpdate($tbl_producto,$datos);
	}
	error_log('Insert Object');
	return doInsert($tbl_producto,$datos);
}

function borrarProducto($datos)
{
	global $tbl_producto;
	if( isset($datos['id']) and strlen($datos['id']) != 0 )
	{
		return doDelete($tbl_producto,$datos);
	}
	return array('resultado'=>false,'error'=>'Identificador para producto incorrecto');
}

function getProducto($idProducto)
{
	global $tbl_producto;
	return doQueryById($tbl_producto,array('id'=>$idProducto));
}




function listarCliente(){
	global $tbl_cliente;
	try {
		$rs=doQuery(getSelect($tbl_cliente));
		return array('clientes'=>$rs );
	} catch (PDOException $ex) {
		show_app_error($ex)	;
		die();
	}
}

function guardarCliente($datos)
{
	global $tbl_cliente;
	if(isset($datos['id']) and strlen($datos['id']) != 0 )
	{
		error_log('Mustt update object');
		return doUpdate($tbl_cliente,$datos);
	}
	error_log('Insert Object');
	return doInsert($tbl_cliente,$datos);
}

function borrarCliente($datos)
{
	global $tbl_cliente;
	if( isset($datos['id']) and strlen($datos['id']) != 0 )
	{
		return doDelete($tbl_cliente,$datos);
	}
	return array('resultado'=>false,'error'=>'Identificador para cliente incorrecto');
}

function getCliente($idCliente)
{
	global $tbl_cliente;
	return doQueryById($tbl_cliente,array('id'=>$idCliente));
}
?>
