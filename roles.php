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

        <title>Gestión de roles</title>
        <script id="lista-roles-tmpl" type="text/template">
            <div class="list-group">{{#roles}}
                <a id="item-link-{{id}}" href="#" class="list-group-item" onclick="mostrarRol('{{id}}')">{{nombre}}</a>
            {{/roles}}</div>
        </script>
    </head>
    <body>
        <!-- Empieza header -->
        <?php include 'header.php' ?>
        <!-- Termina header -->
        <!-- Empieza contenido -->
        <div class="container">
            <h1>Gestión de roles</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button class="btn btn-default" type="button" onclick="loadRoles()"><span class="glyphicon glyphicon-refresh"></span></button> Lista de roles
                        </div>
                        <div id="lista-roles" class="lista-items">
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="panel panel-default hidden-xs">
                        <!-- Barra de herramientas -->
                        <div class="panel-heading">
                            <div class="btn-group">
                                <button id="boton-recargar" class="btn btn-default" type="button" 
                                    onclick="reloadRol()"><span class="glyphicon glyphicon-refresh"></span> Recargar</button>
                                <button class="btn btn-default" type="button" 
                                    onclick="nuevoRol()"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo</button>
                                <button class="btn btn-default" type="button"
                                    onclick="borrarRol()"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button>
                            </div>
                            <div class="btn-group pull-right">
                                <button class="btn btn-default" type="button" 
                                    onclick="guardarRol()"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                                <button class="btn btn-default" type="button"
                                    onclick="resetForm()"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
                            </div>
                        </div>
                        <!-- Termina barra de herramientas -->
                        <!-- Empieza formulario -->
                        <div class="panel-body formulario">
                            <form id="frm-rol" class="form-horizontal" role="form">
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
                                    <label for="tipo" class="col-lg-3 control-label">Tipo</label>
                                    <div class="col-lg-9">
                                        <select id="tipo" name="tipo" class="form-control">
                                            <option value="admin" label="Administrador" >
                                                Administrador
                                            </option>
                                            <option value="cajero" label="Cajero" >
                                                Cajero
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inicio" class="col-lg-3 control-label">Página de inicio</label>
                                    <div class="col-lg-9">
                                        <select id="inicio" name="inicio" class="form-control">
                                            <option value="home.php" label="home.php" >
                                                Bienvenida
                                            </option>
                                            <option value="venta.php" label="venta.php" >
                                                Ventas
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Termina formulario -->
                    </div>
                    <!-- Seccion de mensajes -->
                    <div id="mensajes">
                    </div>
                    <!-- Termina seccion de mensajes -->
                </div>
            </div>
        </div>
        <!-- Termina contenido -->
        <!-- Empieza footer -->
        <?php include 'footer.php' ?>
        <!-- Termina footer -->
        <!-- Empieza javascript -->
        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/mustache.js"></script>
        <script src="js/util.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                // Actualizar la lista de usuarios
                cargarRoles();
            });

            var _accion = 'guardar';
            var _id = null;

            function cargarRoles() {
                $.getJSON('rol_ctrl.php',
                    {accion: 'lista'},
                    function(json) {
                        $('#lista-roles').html(Mustache.to_html($('#lista-roles-tmpl').html(), json));
                        nuevoRol();
                    });
            }

            function nuevoRol() {
                $('a[class~=active]').removeClass('active'); // Limpiar seleccion
                
                _accion = 'guardar'; // Configurar accion
                _id = null;
                clearForm(); // Limpiar el formulario
                enableForm(true); // Habilitar el formulario
            }

            function mostrarRol(idRol) {
                $.getJSON('rol_ctrl.php',
                    {accion: 'item', id: idRol},
                    function(json) {
                        if ( json.resultado ) {
                            $('#id').val(json.item.id);
                            $('#nombre').val(json.item.nombre).focus();
                            $('#tipo').val(json.item.tipo);
                            $('#inicio').val(json.item.inicio);


                            // Hacer seleccion visible
                            $('a[class~=active]').removeClass('active');
                            $('#item-link-' + idRol).addClass('active');

                            //
                            _accion = 'guardar';
                            _id = idRol;
                        } else {
                            _accion = null; // No action
                            _id = null; // No selection
                            uxErrorAlert('Rol no encontrado');
                        }
                    });
            }

            function recargarRol() {
                if (_id != null && _id.length != 0) {
                    mostrarRol(_id);
                }
            }

            function borrarRol() {
                if (_id != null && _id.length != 0) {
                    _accion = 'eliminar';
                    enableForm(false);
                }
            }

            function guardarRol() {
                console.log('Accion: ' + _accion);
                if (_accion == null) {
                    return;
                }

                if (_accion == 'eliminar') {
                    $.post('rol_ctrl.php',
                        {accion: 'eliminar', id: _id},
                        function(json) {
                            if (json.resultado) {
                                cargarRoles();
                                uxSuccessAlert('Rol eliminado correctamente.')
                            } else {
                                uxErrorAlert('No se pudo eliminar el rol. ' + json.error );
                            }
                        });
                } else {
                    var params = $('#frm-rol').serializeArray();
                    params.push({name: 'accion', value: _accion});

                    $.post('rol_ctrl.php',
                        params,
                        function(json) {
                            if (json.resultado) {
                                clearForm();
                                cargarRoles();
                                uxSuccessAlert('Rol guardado correctamente.');
                            } else {
                                uxErrorAlert('No se pudo guardar el rol. ' + json.error );
                            }
                        });
                }
            }

            //--> Funciones de utileria <---
            function resetForm() {
                _accion = 'guardar';
                enableForm(true);
            }

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
        </script>
        <!-- Termina javascript -->
    </body>
</html>