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

        <title>Gestión de usuarios</title>

        <script id="lista-usuarios-tmpl" type="text/template">
            <div class="list-group">
            {{#usuarios}}
                <a id="item-link-{{id}}" href="#" class="list-group-item" onclick="mostrarUsuario('{{id}}')">{{nombre}} {{paterno}}</a>
            {{/usuarios}}
            </div>
        </script>

        <script id="options-rol-tmpl" type="text/template">
            {{#roles}}
            <option value="{{id}}" label="{{nombre}}" />
            {{/roles}}
        </script>
    </head>
    <body>
        <!-- Empieza el encabezado -->
        <?php include 'header.php' ?>
        <!-- Termina el encabezado -->

        <div class="container">
            <h1>Gestión de usuarios</h1>
            <!-- Nuevo/Editar usuario -->
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default" >
                        <div class="panel-heading">
                            <button class="btn btn-default" type="button" onclick="refrescarUsuarios()"><span class="glyphicon glyphicon-refresh"></span></button> Lista de usuarios
                        </div>
                        <div id="lista-usuarios" style="height: 400px; overflow: auto;">
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="panel panel-default hidden-xs">
                        <div class="panel-heading">
                            <div class="btn-group">
                                <button id="boton-recargar" class="btn btn-default" type="button" 
                                    onclick="recargarUsuario()"><span class="glyphicon glyphicon-refresh"></span> Recargar</button>
                                <button class="btn btn-default" type="button" 
                                    onclick="nuevoUsuario()"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo</button>
                                <button class="btn btn-default" type="button"
                                    onclick="borrarUsuario()"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button>
                            </div>
                            <div class="btn-group pull-right">
                                <button class="btn btn-default" type="button" 
                                    onclick="guardarUsuario()"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                                <button class="btn btn-default" type="button"
                                    onclick="cancelarAccion()"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
                            </div>
                        </div>

                        <!-- Comienza el formulario -->
                        <div class="panel-body" style="max-height: 320px; overflow: auto;">
                            <form id="frm-usuario" class="form-horizontal" role="form">
                                <!-- Campos no visibles -->
                                <input id="id" name="id" type="hidden" class="form-control" /> 
                                <!-- Campos editables -->
                                <div class="form-group">
                                    <label for="nombre" class="col-lg-3 control-label">Nombre</label>
                                    <div class="col-lg-9">
                                        <input id="nombre" name="nombre" type="text" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="paterno" class="col-lg-3 control-label">Apellido paterno</label>
                                    <div class="col-lg-9">
                                        <input id="paterno" name="paterno" type="text" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="materno" class="col-lg-3 control-label">Apellido materno</label>
                                    <div class="col-lg-9">
                                        <input id="materno" name="materno" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nusuario" class="col-lg-3 control-label">Usuario</label>
                                    <div class="col-lg-9">
                                        <input id="nusuario" name="nusuario" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="contrasena" class="col-lg-3 control-label">Contraseña</label>
                                    <div class="col-lg-9">
                                        <input id="contrasena" name="contrasena" type="password" class="form-control">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="rol" class="col-lg-3 control-label">Rol</label>
                                    <div class="col-lg-9">
                                        <select id="rol" name="rol" class="form-control">
                                        </select>
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
                refrescarUsuarios();

                // Cargar roles
                $.getJSON('rol_ctrl.php',
                    {accion: 'lista'},
                    function(json) {
                        $('#rol').html(Mustache.to_html($('#options-rol-tmpl').html(), json));
                    });
            });

            // Accion de la pantalla, ninguna por defecto
            var gblAccion = 'guardar';
            var selId = null;

            function guardarUsuario() {
                // Tiene que haber una accion definida
                if (gblAccion == null) {
                    return; // Do nothing
                }

                if (gblAccion == 'eliminar') {
                    $.post('usuario_ctrl.php',
                        {accion: 'eliminar', id: selId},
                        function(json) {
                            if (json.resultado) {
                                refrescarUsuarios();
                                uxSuccessAlert('Usuario eliminado correctamente');
                            } else {
                                uxErrorAlert('No se pudo eliminar el usuario. ' + json.error );
                            }
                        });
                } else { // Guardar o actualizar un usuario
                    var params = $('#frm-usuario').serializeArray();
                    params.push( {name: 'accion', value: gblAccion} );

                    $.post('usuario_ctrl.php', 
                        params,
                        function(json) {
                            if ( json.resultado ) {
                                clearForm();
                                refrescarUsuarios();
                                uxSuccessAlert('El usuario se ha guardado correctamente');
                            } else {
                                // Mostrar error
                                uxErrorAlert('No se pudo guardar el usuario');
                            }
                        });
                }
            }

            function refrescarUsuarios() {
                $.getJSON('usuario_ctrl.php', 
                    {accion: 'lista'}, 
                    function(json){
                        // var tmpl = $('#usuarios-tmpl').html();
                        // var res = Mustache.to_html(tmpl, json);
                        // $('#usuarios').html(res);

                        $('#lista-usuarios').html(Mustache.to_html($('#lista-usuarios-tmpl').html(), json));
                        nuevoUsuario();
                    });
            }

            function mostrarUsuario(idUsuario) {
                $.getJSON('usuario_ctrl.php', 
                    {accion: 'item', id: idUsuario},
                    function(json){
                        if ( json.resultado ) {
                            $('#id').val(json.item.id);
                            $('#nombre').val(json.item.nombre);
                            $('#paterno').val(json.item.paterno);
                            $('#materno').val(json.item.materno);
                            $('#nusuario').val(json.item.usuario);
                            $('#contrasena').val(json.item.contra);
                            $('#rol').val(json.item.id_rol);
                            $('#nombre').focus();

                            // Hacer seleccion visible
                            $('a[class~=active]').removeClass('active');
                            $('#item-link-' + idUsuario).addClass('active');

                            // Accion global: Guardar el item
                            gblAccion = 'guardar'; 
                            selId = idUsuario; // Usuario en vista
                        } else {
                            // Mostrar error
                            gblAccion = null; // No hay accion posible
                            selId = null;
                            uxErrorAlert('No se encontro el usuario');
                        }
                    });
            }

            function recargarUsuario() {
                if (selId != null && selId.length != 0 ){
                    mostrarUsuario(selId);
                } else {
                    console.log('No hay que recargar');
                }
            }

            function nuevoUsuario() {
                $('a[class~=active]').removeClass('active'); // Limpiar seleccion
                
                gblAccion = 'guardar'; // Configurar accion
                selId = null;
                clearForm(); // Limpiar el formulario
                enableForm(true); // Habilitar el formulario
            }

            function borrarUsuario() {
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

            function eliminarUsuario(idUsuario) {
                // Agregarle al botón la funcionalidad de eliminar
                $('#boton-eliminar').one('click', function(){
                    $.post('usuario_ctrl.php',
                        {accion: 'eliminar', id: idUsuario},
                        function(json) {
                            if (json.resultado) {
                                uxSuccessAlert('Usuario eliminado correctamente');
                                refrescarUsuarios();
                            } else {
                                uxErrorAlert('No se pudo eliminar el usuario');
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