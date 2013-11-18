<?php 
require_once( 'catalogo.php' );
require_once( 'fd_admin.php' );

header( 'Content-Type: json' );
if ( isLista() ) {
    echo json_encode( listarRoles() );
} 
else if ( isGuardar() ) 
{
    echo json_encode( guardarRol( $_POST ) );
} 
else if ( isBorrar() ) 
{
	// error_log('borrando...');
    echo json_encode( borrarRol( $_POST ) );
}
else if ( isItem() ) 
{
    # error_log( 'Id a buscar: ' . getItemId() );
    echo json_encode( getRol( getItemId() ) );
} 
?>