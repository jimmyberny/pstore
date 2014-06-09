<?php 
	require_once( 'config.php' );
	
	// header('Content-type: text/xml');
	
	if ( $_FILES['imagen']['error'] > 0 )
	{
		$res = array('error' => true, 'mensaje' => 'El archivo no se ha subido correctamente' );
	}
	else 
	{
		$nombre = $_FILES['imagen']['name'];
		$ext = pathinfo( $nombre, PATHINFO_EXTENSION );
		if ( $ext == 'jpg' || $ext == 'png') 
		{
			$dir = pathinfo(__FILE__, PATHINFO_DIRNAME);
			$nombre = uniqid() . '.' . $ext;
			$rel_name = '/productos/' . $nombre;
			$abs_name = $dir . $rel_name;

			$base = dirname($_SERVER['REQUEST_URI']);
			$move = move_uploaded_file($_FILES['imagen']['tmp_name'],
				$abs_name);

			$res = array('error' => false,
				'mensaje' => 'Archivo subido exitosamente',
				'archivo' => $base . $rel_name,
				'valor' => $nombre );
		} else {
			$res = array( 'error' => true,
				'mensaje' => 'El archivo seleccionado no es una imagen admitida.');
		}
	}

	echo json_encode( $res );
?>