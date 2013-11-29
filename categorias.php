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

        <title>Gestión de Categorias</title>

        <script id="lista-categoria-tmpl" type="text/template">
            <div class="list-group">
            {{#categorias}}
                <a id="item-link-{{id}}" href="#" class="list-group-item" onclick="mostrarCategoria('{{id}}')">{{nombre}}</a>
            {{/categorias}}
            </div>
        </script>
    </head>
    <body>
        <!-- Empieza el encabezado -->
        <?php include 'header.php' ?>
        <!-- Termina el encabezado -->

        <div class="container">
            <h1>Gestión de Categorias</h1>
            <!-- Nuevo/Editar usuario -->
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default" >
                        <div class="panel-heading">
                            <button class="btn btn-default" type="button" onclick="refrescarCategoria()"><span class="glyphicon glyphicon-refresh"></span></button> Lista de Categorias
                        </div>
                        <div id="lista-categoria" style="height: 400px; overflow: auto;">
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="panel panel-default hidden-xs">
                        <div class="panel-heading">
                            <div class="btn-group">
                                <button id="boton-recargar" class="btn btn-default" type="button" 
                                    onclick="recargarCategoria()"><span class="glyphicon glyphicon-refresh"></span> Recargar</button>
                                <button class="btn btn-default" type="button" 
                                    onclick="nuevaCategoria()"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo</button>
                                <button class="btn btn-default" type="button"
                                    onclick="borrarCategoria()"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button>
                            </div>
                            <div class="btn-group pull-right">
                                <button class="btn btn-default" type="button" 
                                    onclick="guardarCategoria()"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                                <button class="btn btn-default" type="button"
                                    onclick="cancelarAccion()"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
                            </div>
                        </div>

                        <!-- Comienza el formulario -->
                        <div class="panel-body" style="max-height: 320px; overflow: auto;">
                            <form id="frm-categoria" class="form-horizontal" role="form">
                                <!-- Campos no visibles -->
                                <input id="id" name="id" type="hidden" class="form-control" /> 
                                <!-- Campos editables -->
                                <div class="form-group">
                                    <label for="nombre" class="col-lg-3 control-label">Nombre</label>
                                    <div class="col-lg-9">
                                        <input id="nombre" name="nombre" type="text" class="form-control" required />
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

            <!-- Tabla de usuarios
            <div class="panel panel-default">
                <div class="panel-heading">
                    Lista de usuarios
                </div>
                <div id="usuarios">
                </div>
            </div>
            -->
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
                refrescarCategoria();

                // Cargar categorias
                $.getJSON('categoria_ctrl.php',
                    {accion: 'lista'},
                    function(json) {
                        $('#categoria').html(Mustache.to_html($('#options-categoria-tmpl').html(), json));
                    });
            });

            // Accion de la pantalla, ninguna por defecto
            var gblAccion = 'guardar';
            var selId = null;

            function guardarCategoria() {
                // Tiene que haber una accion definida
                if (gblAccion == null) {
                    return; // Do nothing
                }

                if (gblAccion == 'eliminar') {
                    $.post('categoria_ctrl.php',
                        {accion: 'eliminar', id: selId},
                        function(json) {
                            if (json.resultado) {
                                refrescarCategoria();
                                uxSuccessAlert('Categoria eliminada correctamente');
                            } else {
                                uxErrorAlert('No se pudo eliminar la categoria. ' + json.error );
                            }
                        });
                } else { // Guardar o actualizar un usuario
                    var params = $('#frm-categoria').serializeArray();
                    params.push( {name: 'accion', value: gblAccion} );

                    $.post('categoria_ctrl.php', 
                        params,
                        function(json) {
                            if ( json.resultado ) {
                                clearForm();
                                refrescarCategoria();
                                uxSuccessAlert('La categoria se ha guardado correctamente');
                            } else {
                                // Mostrar error
                                uxErrorAlert('No se pudo guardar la categoria');
                            }
                        });
                }
            }

            function refrescarCategoria() {
                $.getJSON('categoria_ctrl.php', 
                    {accion: 'lista'}, 
                    function(json){
                        // var tmpl = $('#usuarios-tmpl').html();
                        // var res = Mustache.to_html(tmpl, json);
                        // $('#usuarios').html(res);

                        $('#lista-categoria').html(Mustache.to_html($('#lista-categoria-tmpl').html(), json));
                        nuevaCategoria();
                    });
            }

            function mostrarCategoria(idCategoria) {
                $.getJSON('categoria_ctrl.php', 
                    {accion: 'item', id: idCategoria},
                    function(json){
                        if ( json.resultado ) {
                            $('#id').val(json.item.id);
                            $('#nombre').val(json.item.nombre);
                            $('#nombre').focus();

                            // Hacer seleccion visible
                            $('a[class~=active]').removeClass('active');
                            $('#item-link-' + idCategoria).addClass('active');

                            // Accion global: Guardar el item
                            gblAccion = 'guardar'; 
                            selId = idCategoria; // Usuario en vista
                        } else {
                            // Mostrar error
                            gblAccion = null; // No hay accion posible
                            selId = null;
                            uxErrorAlert('No se encontro la categoria');
                        }
                    });
            }

            function recargarCategoria() {
                if (selId != null && selId.length != 0 ){
                    mostrarCategoria(selId);
                } else {
                    console.log('No hay que recargar');
                }
            }

            function nuevaCategoria() {
                $('a[class~=active]').removeClass('active'); // Limpiar seleccion
                
                gblAccion = 'guardar'; // Configurar accion
                selId = null;
                clearForm(); // Limpiar el formulario
                enableForm(true); // Habilitar el formulario
            }

            function borrarCategoria() {
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

            function eliminarCategoria(idCategoria) {
                // Agregarle al botón la funcionalidad de eliminar
                $('#boton-eliminar').one('click', function(){
                    $.post('categoria_ctrl.php',
                        {accion: 'eliminar', id: idCategoria},
                        function(json) {
                            if (json.resultado) {
                                uxSuccessAlert('Categoria eliminada correctamente');
                                refrescarUsuarios();
                            } else {
                                uxErrorAlert('No se pudo eliminar la categoria');
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