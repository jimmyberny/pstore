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

        <title>Gestión de Productos</title>

        <script id="lista-producto-tmpl" type="text/template">
            <div class="list-group">
            {{#producto}}
                <a id="item-link-{{id}}" href="#" class="list-group-item" onclick="mostrarProducto('{{id}}')">{{nombre}}</a>
            {{/producto}}
            </div>
        </script>

        <script id="options-categoria-tmpl" type="text/template">
            {{#categorias}}
            <option value="{{id}}" label="{{nombre}}" >
                {{nombre}}
            </option>
            {{/categorias}}
        </script>
    </head>
    <body>
        <!-- Empieza el encabezado -->
        <?php include 'header.php' ?>
        <!-- Termina el encabezado -->

        <div class="container">
            <h1>Gestión de Productos</h1>
            <!-- Nuevo/Editar usuario -->
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default" >
                        <div class="panel-heading">
                            <button class="btn btn-default" type="button" onclick="refrescarProducto()"><span class="glyphicon glyphicon-refresh"></span></button> Lista de productos
                        </div>
                        <div id="lista-producto" style="height: 400px; overflow: auto;">
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="panel panel-default hidden-xs">
                        <div class="panel-heading">
                            <div class="btn-group">
                                <button id="boton-recargar" class="btn btn-default" type="button" 
                                    onclick="recargarProducto()"><span class="glyphicon glyphicon-refresh"></span> Recargar</button>
                                <button class="btn btn-default" type="button" 
                                    onclick="nuevoProducto()"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo</button>
                                <button class="btn btn-default" type="button"
                                    onclick="borrarProducto()"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button>
                            </div>
                            <div class="btn-group pull-right">
                                <button class="btn btn-default" type="button" 
                                    onclick="guardarProducto()"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
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
                                    <label for="categoria" class="col-lg-3 control-label">Categoria</label>
                                    <div class="col-lg-9">
                                        <select id="categoria" name="categoria" class="form-control">
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
                                    <label for="codigo" class="col-lg-3 control-label">Codigo</label>
                                    <div class="col-lg-9">
                                        <input id="codigo" name="codigo" type="text" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion" class="col-lg-3 control-label">Descripcion</label>
                                    <div class="col-lg-9">
                                        <input id="descripcion" name="descripcion" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="existencia" class="col-lg-3 control-label">Existencia</label>
                                    <div class="col-lg-9">
                                        <input id="existencia" name="existencia" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="minimo" class="col-lg-3 control-label">Minimo</label>
                                    <div class="col-lg-9">
                                        <input id="minimo" name="minimo" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="venta" class="col-lg-3 control-label">Precio de venta</label>
                                    <div class="col-lg-9">
                                        <input id="venta" name="venta" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="compra" class="col-lg-3 control-label">Compra</label>
                                    <div class="col-lg-9">
                                        <input id="compra" name="compra" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="iva" class="col-lg-3 control-label">IVA</label>
                                    <div class="col-lg-9">
                                        <input id="iva" name="iva" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <input id="imagen" name="imagen" type="hidden" value="" />
                                    
                                    <label class="col-lg-3 control-label">Imágen</label>
                                    <div class="col-lg-9">
                                        <div id="img-vista-previa">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form id="frm-imagen" class="frm-imagen form-horizontal" role="form"
                                action="subir_archivo.php" method="post" enctype="multipart/form-data">
                                <!-- enctype="multipart" method="post" action="subir_imagen.php" -->
                                <div class="form-group">
                                    <label for="imagen" class="col-lg-3 control-label">Subir archivo</label>
                                    <div class="col-lg-7">
                                        <input id="imagen" name="imagen" type="file" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="submit" value="Subir" class="btn btn-default" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9 col-lg-offset-3">
                                        <div class="progreso ">
                                            <div class="img-barra"></div>
                                            <div class="img-avance">0%</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="img-estado col-lg-9 col-lg-offset-3"></div>
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
        <script src="js/jquery.form.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/mustache.js"></script>
        <script src="js/util.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                // Actualizar la lista de usuarios
                refrescarProductos();

                // Cargar categorias
                $.getJSON('categoria_ctrl.php',
                    {accion: 'lista'},
                    function(json) {
                        $('#categoria').html(Mustache.to_html($('#options-categoria-tmpl').html(), json));
                    });

                var barra = $('.img-barra');
                var avance = $('.img-avance');
                var estado = $('.img-estado');

                $('#frm-imagen').ajaxForm({
                    dataType: 'json',
                    beforeSend: function() {
                        estado.empty();
                        barra.width('0%');
                        avance.html('0%');
                    },
                    uploadProgress: function(event, pos, total, complete) {
                        var val = complete + '%';
                        barra.width(val);
                        avance.width(val);
                    },
                    success: function(data) {
                        barra.width('100%');
                        avance.html('100%');
                    },
                    complete: function(data) {
                        var json = data.responseJSON;

                        estado.html(json.mensaje);
                        if (json.error) {
                            barra.css('background-color', '#FF8080');
                            avance.html('Error');
                        } else {
                            barra.css('background-color', '#80FF80');
                            $('#img-vista-previa').html('<img src="' + json.archivo +'" class="vista-previa" />');
                            $('#imagen').attr('value', json.valor);
                        }
                    }
                });

            });

            // Accion de la pantalla, ninguna por defecto
            var gblAccion = 'guardar';
            var selId = null;

            function guardarProducto () {
                // Tiene que haber una accion definida
                if (gblAccion == null) {
                    return; // Do nothing
                }

                if (gblAccion == 'eliminar') {
                    $.post('producto_ctrl.php',
                        {accion: 'eliminar', id: selId},
                        function(json) {
                            if (json.resultado) {
                                refrescarProductos();
                                uxSuccessAlert('Producto eliminado correctamente');
                            } else {
                                uxErrorAlert('No se pudo eliminar el producto. ' + json.error );
                            }
                        });
                } else { // Guardar o actualizar un usuario
                    var params = $('#frm-producto').serializeArray();
                    params.push( {name: 'accion', value: gblAccion} );

                    $.post('producto_ctrl.php', 
                        params,
                        function(json) {
                            if ( json.resultado ) {
                                clearForm();
                                refrescarProductos();
                                uxSuccessAlert('El producto se ha guardado correctamente');
                            } else {
                                // Mostrar error
                                uxErrorAlert('No se pudo guardar el producto');
                            }
                        });
                }
            }

            function refrescarProductos() {
                $.getJSON('producto_ctrl.php', 
                    {accion: 'lista'}, 
                    function( json ){
                        $('#lista-producto').html(Mustache.to_html($('#lista-producto-tmpl').html(), json));
                        nuevoProducto();
                    });
            }

            function mostrarProducto(idProducto) {
                $.getJSON('producto_ctrl.php', 
                    {accion: 'item', id: idProducto},
                    function(json){
                        if ( json.resultado ) {
                            $('#id').val(json.item.id);
                            $('#categoria').val(json.item.id_categoria);
                            $('#nombre').val(json.item.nombre);
                            $('#codigo').val(json.item.codigo);
                            $('#descripcion').val(json.item.descripcion);
                            $('#existencia').val(json.item.existencia);
                            $('#minimo').val(json.item.minimo);
                            $('#venta').val(json.item.venta);
                            $('#compra').val(json.item.compra);
                            $('#iva').val(json.item.iva);

                            // Trabajar con la imagen
                            var img = json.item.imagen;
                            if (img != null && img.length != 0) {
                                $('#img-vista-previa').html('<img src="productos/' + img +'" class="vista-previa" />');
                                $('.img-barra').css('background-color', '#000000');
                            } else {
                                $('#img-vista-previa').html('Sin imagen');
                            }
                            $('#nombre').focus();

                            // Hacer seleccion visible
                            $('a[class~=active]').removeClass('active');
                            $('#item-link-' + idProducto).addClass('active');

                            // Accion global: Guardar el item
                            gblAccion = 'guardar'; 
                            selId = idProducto; // Usuario en vista
                        } else {
                            // Mostrar error
                            gblAccion = null; // No hay accion posible
                            selId = null;
                            uxErrorAlert('No se encontro el producto');
                        }
                    });
            }

            function recargarProducto() {
                if (selId != null && selId.length != 0 ){
                    mostrarProducto(selId);
                } else {
                    console.log('No hay que recargar');
                }
            }

            function nuevoProducto() {
                $('a[class~=active]').removeClass('active'); // Limpiar seleccion
                
                gblAccion = 'guardar'; // Configurar accion
                selId = null;
                clearForm(); // Limpiar el formulario
                enableForm(true); // Habilitar el formulario
            }

            function borrarProducto() {
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

            function eliminarProducto(idProducto) {
                // Agregarle al botón la funcionalidad de eliminar
                $('#boton-eliminar').one('click', function(){
                    $.post('producto_ctrl.php',
                        {accion: 'eliminar', id: idProducto},
                        function(json) {
                            if (json.resultado) {
                                uxSuccessAlert('Producto eliminado correctamente');
                                refrescarProducto();
                            } else {
                                uxErrorAlert('No se pudo eliminar el producto');
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