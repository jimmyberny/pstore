<?php 
require_once( 'admin.php' );
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<!-- <link rel="shortcut icon" href=""> -->
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-theme.css">
        <link rel="stylesheet" href="css/papeleria.css">

        <script id="tbl-existencias" type="text/template">
            <table class="table">
                <thead>
                    <tr>
                        <th> </th>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Existencia</th>
                        <th>Minimo</th>
                    </tr>
                </thead>
                <tbody>
                    {{#producto}}<tr>
                        <td><img src="productos/{{imagen}}" class="img-micro" onclick="mostrarImg('{{nombre}}','{{imagen}}');" /></td>
                        <td>{{codigo}}</td>
                        <td>{{nombre}}</td>
                        <td>{{existencia}}</td>
                        <td>{{minimo}}</td>
                    </tr>{{/producto}}
                </tbody>
            </table>
        </script>
    </head>
    <body>
    	<!-- Empieza el encabezado -->
    	<?php include 'header.php' ?>
		<!-- Termina el encabezado -->
		<!-- Empieza el contenido de la página -->
    	<div class="container">
    		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Caja actual</h3>
                        </div>
                        <div class="panel-body">
                            <form id="frm-cerrar-caja" class="form-horizontal" role="form">
                                <div class="form-group">
                                    <label for="inicio" class="col-lg-2 control-label">Inicio: </label>
                                    <div class="col-lg-4">
                                        <input id="inicio" name="inicio" type="text" class="form-control" disabled />
                                    </div>
                                    <label for="fin" class="col-lg-2 control-label">Fin: </label>
                                    <div class="col-lg-4">
                                        <input id="fin" name="fin" type="text" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for"total" class="col-lg-2 control-label">Total: </label>
                                    <div class="col-lg-10">
                                        <input id="total" name="total" type="text" class="form-control" disabled />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <h3 class="panel-title">Existencias</h3>
                        </div>
                        <div id="tabla-existencias" class="panel-body">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dialogo para la imagen -->
            <div id="dialogo-imagen" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 id="dlg-nombre-producto" class="modal-title"></h4>
                        </div>
                        <div id="dlg-img-producto" class="modal-body">
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    	<!-- Termina el contenido -->
    	<!-- Empieza el pie -->
    	<?php include 'footer.php' ?>
    	<!-- Terminal el pie -->
    	<!-- Empieza javascript -->
    	<script src="js/jquery-1.10.2.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/mustache.js"></script>
        <script src="js/util.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                // Cargar información de la caja actual
                actualizarInfo(); 

                //
                mostrarExistencias();
            });

            function actualizarInfo() {
                $.post('corte_caja_ctrl.php', 
                    {accion: 'consultar'},
                    function( json ) {
                        if ( json.resultado ) {
                            $('#inicio').val( json.inicio );
                            $('#fin').val( json.fin );
                            $('#total').val( json.total );
                        } else {
                            uxErrorAlert( json.error );
                        }
                    });
            }

            function mostrarExistencias() {
                $.getJSON('producto_ctrl.php',
                    {accion: 'lista'},
                    function( json ) {
                        $('#tabla-existencias').html(Mustache.to_html($('#tbl-existencias').html(), json));
                    });
            }

            function mostrarImg(name, img) {
                // Nombre
                $('#dlg-nombre-producto').html(name);
                // Imagen
                $('#dlg-img-producto').html('<img src="productos/' + img + '" class="img-normal" />');
                $('#dialogo-imagen').modal();
            }
        </script>
    	<!-- Termina javascript -->
    </body>
</html>
