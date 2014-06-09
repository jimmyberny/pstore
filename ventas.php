<?php 
require_once( 'admin.php' );
?>
<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="shortcut icon" href=""> -->
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-theme.css">
        <link rel="stylesheet" href="css/papeleria.css">

        <script id="item-busqueda-tmpl" type="text/template">
            <div class="list-group">
            {{#productos}}
                <a id="item-link-{{id}}" href="#" class="list-group-item" onclick="agregarProducto('{{codigo}}')">
                    <div class="item-producto">
                        <div class="img-mini">
                            <img src="productos/{{imagen}}" class="img-mini" />
                        </div>
                        <div>
                            {{nombre}}
                        </div>
                    </div>
                </a>
            {{/productos}}
            </div>
        </script>

        <script id="tabla-lineas-tmpl" type="text/template">
            <table class="table">
                <thead>
                    <tr>
                        <th> </th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    {{#lineas}}<tr>
                        <td><img src="productos/{{imagen}}" class="img-micro" onclick="mostrarImg('{{nombre}}','{{imagen}}');" /></td>
                        <td>{{nombre}}</td>
                        <td>{{cantidad}}</td>
                        <td>{{precio}}</td>
                        <td>{{total}}</td>
                        <td style="width: 50px;"><button class="btn btn-default" type="button" onclick="agregarProducto('{{codigo}}')">
                            <span class="glyphicon glyphicon-plus-sign"></span> 
                        </button></td>
                    </tr>{{/lineas}}
                </tbody>
            </table>
        </script>

        <title>Ventas</title>
    </head>
    <body>

        <!-- Empieza el encabezado -->
        <?php include 'header.php' ?>
        <!-- Termina el encabezado -->

        <!-- Contenido -->
        <div class="container">
            <h1>Ventas</h1>
            <div class="row">
                <!-- Lista de búsqueda -->
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <form id="frm-busqueda">
                                <div class="input-group">
                                    <input id="busqueda" type="text" class="form-control" name="busqueda" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" onclick="lanzarBusqueda()">
                                            <span class="glyphicon glyphicon-flash"></span>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div id="lista-resultados" class="lista-items">
                            <!-- Aqui va lo que resulte de la búsqueda -->
                            <!-- Si no se encuentra un producto, entonces -->
                            <!-- se lanza una búsqueda por nombre -->
                        </div>
                    </div>
                </div>
                <!-- Termina lista de búsqueda -->
                <!-- Empieza panel ticket -->
                <div class="col-md-8">
                    <!-- Empieza informacion del ticket -->
                    <!-- Termina informacion del ticket -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button id="boton-actualizar" class="btn btn-default" type="button" onclick="actualizarTicket()">
                                <span class="glyphicon glyphicon-repeat"> </span>
                            </button>
                            <strong>Ticket actual</strong>
                            <div class="btn-group pull-right">
                                <button id="boton-vender" class="btn btn-default" type="button" onclick="pagar()"> 
                                    <!-- data-toggle="modal" data-target="#dialogo-pagar" >-->
                                    <span class="glyphicon glyphicon-usd"></span> Vender
                                </button>
                            </div>
                        </div>
                        <div id="tabla-lineas" class="formulario">
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h4>Total: <strong id="vista-total"></strong></h4>
                                </div>
                                <div class="col-lg-4">
                                    <!-- Enlace para imprimir el ultimo ticket -->
                                    <!-- Si no se ha vendido nada, el enlace no hace nada DAAAH!! -->
                                    <a id="link-imprimir" href="#" class="btn btn-default btn-block">Imprimir último ticket</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="mensajes">
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
                <!-- Termina panel ticket -->
                <!-- Empieza panel de dialogo -->
                <div id="dialogo-pagar" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Total</h4>
                            </div>
                            <div class="modal-body">
                                <form id="frm-producto" class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <label for="total" class="col-lg-3 control-label">Total: </label>
                                        <div class="col-lg-9">
                                            <input id="total" name="total" type="text" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="recibido" class="col-lg-3 control-label">Recibido: </label>
                                        <div class="col-lg-9">
                                            <input id="recibido" name="recibido" type="text" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cambio" class="col-lg-3 control-label">Cambio: </label>
                                        <div class="col-lg-9">
                                            <input id="cambio" name="cambio" type="text" class="form-control" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="guardar()">Pagar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Termina contenido -->
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

                // Mostrar el contenido del ticket. 
                // El ticket es uno solo a lo largo de toda la aplicación
                actualizarTicket();

                // Bindear la modificacion del pago y cambio
                $('#recibido').bind('keyup', function(){
                        $('#cambio').val(this.value - $('#total').val());
                    });
            });

            function mostrarImg(name, img) {
                // Nombre
                $('#dlg-nombre-producto').html(name);
                // Imagen
                $('#dlg-img-producto').html('<img src="productos/' + img + '" class="img-normal" />');
                $('#dialogo-imagen').modal();
            }

            function lanzarBusqueda() {
                var params = $('#frm-busqueda').serializeArray();
                $.post('busqueda_ctrl.php',
                    params,
                    function( json ) {
                        if ( json.resultado ) { // Busqueda y renderizable
                            if ( json.actualizar ) {
                                $('#lista-resultados').html(Mustache.to_html($('#item-busqueda-tmpl').html(), json));
                            } else {
                                var $caja = $('#busqueda');
                                $caja.val(function(){return this.defaultValue;});
                                $caja.focus();
                            }
                            actualizarTicket();
                        } else {
                            // Render mensajes
                            uxErrorAlert(json.error);
                        }
                    });
            }

            function actualizarTicket() {
                $.get('venta_ctrl.php', 
                    {accion: 'listar'}, 
                    function(json) {
                        if (json.resultado) {
                            $('#tabla-lineas').html(Mustache.to_html($('#tabla-lineas-tmpl').html(), json));
                            $('#vista-total').html(json.total);
                        } else{
                            alert(json.error);
                        }
                    });
            }

            function agregarProducto(codigo) {
                $.post('busqueda_ctrl.php',
                    {busqueda: codigo},
                    function(json) {
                        if (json.resultado) {
                            actualizarTicket();
                        } else {
                            uxErrorAlert(json.error);
                        }
                    });
            }

            function pagar() {
                $.post('venta_ctrl.php',
                    {accion: 'vender'},
                    function(json) {
                        if (json.resultado) {
                            $('#dialogo-pagar').modal();
                            $('#total').val(json.total);
                            $('#recibido').val(json.total);
                            $('#cambio').val(0);
                        }
                    });
            }

            function guardar() {
                $.post('venta_ctrl.php',
                    {
                        accion: 'guardar', 
                        recibido: $('#recibido').val()
                    },
                    function(json) {
                        if (json.resultado) {
                            // Pedir el pdf correspondiente
                            // var w = window.open('_blank', 'Nueva ventana'); 
                            // w.location = 'ticket_ctrl.php?accion=ticket&ticket=' + json.ticket;

                            // $.post('ticket_ctrl.php', 
                                // {accion: 'ticket', ticket: json.ticket }); // Simple, sin callback
                            var $link = $('#link-imprimir');
                            $link.attr('href', 'ticket_ctrl.php?accion=ticket&ticket=' + json.ticket);

                            // Actualizar la apariencia
                            $('#dialogo-pagar').modal('hide'); // Ocultar el dialogo
                            uxSuccessAlert(json.mensaje);
                            actualizarTicket();
                        } else {
                            uxErrorAlert(json.error);
                        }
                    });
            }
        </script>
    </body>
</html>