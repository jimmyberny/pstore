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

        <title>Gestión de Clientes</title>

        <script id="lista-cliente-tmpl" type="text/template">
            <div class="list-group">
            {{#clientes}}
                <a id="item-link-{{id}}" href="#" class="list-group-item" onclick="mostrarCliente('{{id}}')">{{nombre}}</a>
            {{/clientes}}
            </div>
        </script>

    </head>
    <body>
        <!-- Empieza el encabezado -->
        <?php include 'header.php' ?>
        <!-- Termina el encabezado -->

        <div class="container">
            <h1>Gestión de Clietes</h1>
            <!-- Nuevo/Editar usuario -->
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default" >
                        <div class="panel-heading">
                            <button class="btn btn-default" type="button" onclick="refrescarCliente()"><span class="glyphicon glyphicon-refresh"></span></button> Lista de Clientes
                        </div>
                        <div id="lista-cliente" style="height: 400px; overflow: auto;">
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="panel panel-default hidden-xs">
                        <div class="panel-heading">
                            <div class="btn-group">
                                <button id="boton-recargar" class="btn btn-default" type="button" 
                                    onclick="recargarCliente()"><span class="glyphicon glyphicon-refresh"></span> Recargar</button>
                                <button class="btn btn-default" type="button" 
                                    onclick="nuevoCliente()"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo</button>
                                <button class="btn btn-default" type="button"
                                    onclick="borrarCliente()"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button>
                            </div>
                            <div class="btn-group pull-right">
                                <button class="btn btn-default" type="button" 
                                    onclick="guardarCliente()"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                                <button class="btn btn-default" type="button"
                                    onclick="cancelarAccion()"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
                            </div>
                        </div>

                        <!-- Comienza el formulario -->
                        <div class="panel-body" style="max-height: 320px; overflow: auto;">
                            <form id="frm-producto" class="form-horizontal" role="form">
                                <!-- Campos no visibles -->
                                <input id="id" name="id" type="hidden" class="form-control" /> 
                                <!-- Campos editables -->
                                <div class="form-group">
                                    <label for="rfc" class="col-lg-3 control-label">RFC</label>
                                    <div class="col-lg-9">
                                        <input id="rfc" name="rfc" type="text" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nombre" class="col-lg-3 control-label">Nombre</label>
                                    <div class="col-lg-9">
                                        <input id="nombre" name="nombre" type="text" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="paterno" class="col-lg-3 control-label">Paterno</label>
                                    <div class="col-lg-9">
                                        <input id="paterno" name="paterno" type="text" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="materno" class="col-lg-3 control-label">Materno</label>
                                    <div class="col-lg-9">
                                        <input id="materno" name="materno" type="text" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="proveedor" class="col-lg-3 control-label">Tipo</label>
                                    <div class="col-lg-9">
                                        <select id="proveedor" name="proveedor" class="form-control">
                                            <option value="1">proveedor</option>
                                            <option Value="2">cliente</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="calle" class="col-lg-3 control-label">Calle</label>
                                    <div class="col-lg-9">
                                        <input id="calle" name="calle" type="text" class="form-control" required >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="interior" class="col-lg-3 control-label">Interior</label>
                                    <div class="col-lg-9">
                                        <input id="interior" name="interior" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exterior" class="col-lg-3 control-label">Exterior</label>
                                    <div class="col-lg-9">
                                        <input id="exterior" name="exterior" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="colonia" class="col-lg-3 control-label">Colonia</label>
                                    <div class="col-lg-9">
                                        <input id="colonia" name="colonia" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ciudad" class="col-lg-3 control-label">Ciudad</label>
                                    <div class="col-lg-9">
                                        <input id="ciudad" name="ciudad" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="estado" class="col-lg-3 control-label">Estado</label>
                                    <div class="col-lg-9">
                                        <input id="estado" name="estado" type="text" class="form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Mensajes -->
                    <div id="mensajes">
                    </div>
                </div>
            </div>
            

        </div>
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
                // Actualizar la lista de usuarios
                refrescarCliente();

                // Cargar roles
                $.getJSON('cliente_ctrl.php',
                    {accion: 'lista'},
                    function(json) {
                        $('#cliente').html(Mustache.to_html($('#options-cliente-tmpl').html(), json));
                    });
            });

            // Accion de la pantalla, ninguna por defecto
            var gblAccion = 'guardar';
            var selId = null;

            function guardarCliente () {
                // Tiene que haber una accion definida
                debugger;
                if (gblAccion == null) {
                    return; // Do nothing
                }

                if (gblAccion == 'eliminar') {
                    $.post('cliente_ctrl.php',
                        {accion: 'eliminar', id: selId},
                        function(json) {
                            if (json.resultado) {
                                refrescarCliente();
                                uxSuccessAlert('Cliente eliminado correctamente');
                            } else {
                                uxErrorAlert('No se pudo eliminar el cliente' + json.error );
                            }
                        });
                } else { // Guardar o actualizar un usuario
                    var params = $('#frm-producto').serializeArray();
                    params.push( {name: 'accion', value: gblAccion} );

                    $.post('cliente_ctrl.php', 
                        params,
                        function(json) {
                            if ( json.resultado ) {
                                clearForm();
                                refrescarCliente();
                                uxSuccessAlert('El cliente se ha guardado correctamente');
                            } else {
                                // Mostrar error
                                uxErrorAlert('No se pudo guardar el producto');
                            }
                        });
                }
            }

            function refrescarCliente() {
                $.getJSON('Cliente_ctrl.php', 
                    {accion: 'lista'}, 
                    function(json){
                        // var tmpl = $('#usuarios-tmpl').html();
                        // var res = Mustache.to_html(tmpl, json);
                        // $('#usuarios').html(res);

                        $('#lista-cliente').html(Mustache.to_html($('#lista-cliente-tmpl').html(), json));
                        nuevoCliente();
                    });
            }

            function mostrarCliente(idCliente) {
                $.getJSON('cliente_ctrl.php', 
                    {accion: 'item', id: idCliente},
                    function(json){
                        if ( json.resultado ) {
                            debugger;
                            $('#id').val(json.item.id);
                            $('#rfc').val(json.item.rfc);
                            $('#nombre').val(json.item.nombre);
                            $('#paterno').val(json.item.paterno);
                            $('#materno').val(json.item.materno);
                            $('#proveedor').val(json.item.proveedor);
                            $('#calle').val(json.item.calle);
                            $('#interior').val(json.item.interior);
                            $('#exterior').val(json.item.exterior);
                            $('#colonia').val(json.item.colonia);
                            $('#ciudad').val(json.item.ciudad);
                            $('#estado').val(json.item.estado);
                            $('#rfc').focus();


                            // Hacer seleccion visible
                            $('a[class~=active]').removeClass('active');
                            $('#item-link-' + idCliente).addClass('active');

                            // Accion global: Guardar el item
                            gblAccion = 'guardar'; 
                            selId = idCliente; // Usuario en vista
                        } else {
                            // Mostrar error
                            gblAccion = null; // No hay accion posible
                            selId = null;
                            uxErrorAlert('No se encontro el cliente');
                        }
                    });
            }

            function recargarCliente() {
                if (selId != null && selId.length != 0 ){
                    mostrarCliente(selId);
                } else {
                    console.log('No hay que recargar');
                }
            }

            function nuevoCliente() {
                $('a[class~=active]').removeClass('active'); // Limpiar seleccion
                
                gblAccion = 'guardar'; // Configurar accion
                selId = null;
                clearForm(); // Limpiar el formulario
                enableForm(true); // Habilitar el formulario
            }

            function borrarCliente() {
                if (selId != null) {
                    gblAccion = 'eliminar'; 
                    enableForm(false);
                } else {
                    console.log('No existe selección');
                }
            }

            function cancelarAccion() {
                gblAccion = 'guardar';
                enableForm(true); // 
            }

            function eliminarCliente(idCliente) {
                // Agregarle al botón la funcionalidad de eliminar
                $('#boton-eliminar').one('click', function(){
                    $.post('cliente_ctrl.php',
                        {accion: 'eliminar', id: idCliente},
                        function(json) {
                            if (json.resultado) {
                                uxSuccessAlert('Cliente eliminado correctamente');
                                refrescarCliente();
                            } else {
                                uxErrorAlert('No se pudo eliminar el cliente');
                            }
                        });
                    $('#modal-eliminar').modal('hide');
                });

                // Mostrar el diálogo
                $('#modal-eliminar').modal('show');
            }

            //--> Funciones de utiliería <--//
            function clearForm() {
                $('.form-control').val( function() {
                    return this.defaultValue;
                });
                // El campo tipo 'hidden' no se comporta como los otros
                $('#id').val(null);
            }

            function enableForm(enable) {
                // Desactivar la entrada de datos
                if (enable){
                    $('.form-control').each(function(){
                            $(this).removeAttr('disabled');
                        });
                } else {
                    $('.form-control').each(function(){
                            $(this).attr('disabled', 'true');
                        });
                }
            }
            //--> Terminan funciones de utilería <--//
        </script>
    </body>
</html>