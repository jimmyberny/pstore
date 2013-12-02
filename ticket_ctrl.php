<?php
require_once( 'admin.php' );
require_once( 'fpdf.php' );
require_once( 'fd_admin.php' );
require_once( 'util.php' );

// No importa si es GET o POST
$accion = isset( $_POST['accion'] ) ? $_POST['accion'] : isset( $_GET['accion'] ) ? $_GET['accion'] : null;
$ticket = isset( $_POST['ticket'] ) ? $_POST['ticket'] : isset( $_GET['ticket'] ) ? $_GET['ticket'] : null; 

if ( !is_null( $accion ) )
{
	if ( match( $accion, 'ticket' ) )
	{
		$infoTicket = obtenerTicket( $ticket );
		if ( !is_null( $infoTicket ) )
		{
			$fecha = date_format( date_create( $infoTicket['ticket']['fecha'] ), 'Y-m-d H:i:s');

			// PDF
			$pdf = new FPDF();
			$pdf->AddPage(); // una hoja
			$pdf->SetFont('Courier', 'B', 20);
			$pdf->Cell(180, 20, 'Ticket de venta', 1, 1, 'C');

			$pdf->SetFont('Courier', '', 14);
			$pdf->Cell(180, 10, 'Fecha: ' . $fecha , 'B', 1, 'R');
			
			// Encabezado de las lineas
			// Borde 0, 1, L, T, R, B 
			// Ln 0->flow, 1->CR LF, 2->below
			// Align L C R  
			$pdf->SetFont('Courier', 'B', 16);
			$pdf->Cell(80, 10, 'Producto', 'B', 0);
			$pdf->Cell(30, 10, 'Cantidad', 'B', 0, 'R');
			$pdf->Cell(30, 10, 'Precio', 'B', 0, 'R');
			$pdf->Cell(30, 10, 'Total', 'B', 1, 'R'); // Salto de linea
			
			// Las lineas de venta
			$pdf->SetFont('Courier', '', 12);
			$lineas = $infoTicket['lineas'];
			$total = 0;
			foreach ($lineas as $lin) {
				$pdf->Cell(80, 8, $lin['producto'], '', 0);
				$pdf->Cell(30, 8, $lin['cantidad'], '', 0, 'R');
				$pdf->Cell(30, 8, $lin['precio'], '', 0, 'R');
				$pdf->Cell(30, 8, $lin['total'], '', 1, 'R');

				$total += $lin['total'];
			}

			// Total
			$pdf->SetFont('Courier', 'B', 16);
			$pdf->Cell(110, 10, '', 'T'); // Relleno
			$pdf->Cell(30, 10, 'Total', 'T', 0, 'R');
			$pdf->Cell(30, 10, $total, 'T', 1, 'R');

			// Terminarlo
			// header( 'Content-Type: application/pdf');
			$pdf->Output('Ticket.pdf', 'D'); // o I, es lo mismo
		} // 
		else
		{
			// No hay ticket... *corre en circulos*
			die('No se encontro el ticket ticket');
		}
	}
	else
	{
		die( 'Accion incorrecta' );
	}
} else {
	die( 'Llamada incorrecta' );
}
?>