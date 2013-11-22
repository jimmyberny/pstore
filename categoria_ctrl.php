<?php 
require_once( 'catalogo.php' );
require_once( 'fd_admin.php' );

header( 'Content-Type: json' );
if ( isLista() ) {
    echo json_encode( listarCategoria() );
} 
else if ( isGuardar() ) 
{
    echo json_encode( guardarCategoria( $_POST ) );
} 
else if ( isBorrar() ) 
{
	// error_log('borrando...');
    echo json_encode( borrarCategoria( $_POST ) );
}
else if ( isItem() ) 
{
    # error_log( 'Id a buscar: ' . getItemId() );
    echo json_encode( getcategoria( getItemId() ) );
} 
?>