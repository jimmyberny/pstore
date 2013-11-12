<?php

?>

<!doctype html>
<html lang="es">
    <head>
        <meta charset="uft-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="shortcut icon" href=""> -->
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-theme.css">

        <title>Gestión de usuarios</title>

        <script id="usuarios_tmpl" type="text/template">
            <table class="table">
                <thead>
                    <tr>
                        <td>Nombre</td>
                        <td>Apellido paterno</td>
                        <td>Apellido materno</td>
                        <td>Usuario</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>{{#usuarios}}
                <tr id="fila-usuario-{{id}}">
                    <td>{{nombre}}</td>
                    <td>{{paterno}}</td>
                    <td>{{materno}}</td>
                    <td>{{usuario}}</td>
                    <td>
                        <button type="button" onclick="mostrarUsuario('{{id}}')" class="btn btn-default">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                    </td>
                </tr>
                {{/usuarios}}</tbody>
            </table>
        </script>
    </head>
    <body>
        <div class="container">
            <h1>Gestión de usuarios</h1>
            <!-- Nuevo/Editar usuario -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Usuario
                </div>
                <div class="panel-body">
                    <form id="frm-usuario" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="nombre" class="col-lg-2 control-label">Nombre</label>
                            <div class="col-lg-10">
                                <input id="nombre" name="nombre" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="paterno" class="col-lg-2 control-label">Apellido paterno</label>
                            <div class="col-lg-10">
                                <input id="paterno" name="paterno" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="materno" class="col-lg-2 control-label">Apellido materno</label>
                            <div class="col-lg-10">
                                <input id="materno" name="materno" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nusuario" class="col-lg-2 control-label">Usuario</label>
                            <div class="col-lg-10">
                                <input id="nusuario" name="nusuario" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contrasena" class="col-lg-2 control-label">Contraseña</label>
                            <div class="col-lg-10">
                                <input id="contrasena" name="contrasena" type="password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button id="boton-guardar" type="button" class="btn btn-default">
                                    <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
                                </button>
                                <button id="boton-guardar" type="reset" class="btn" >
                                    <span class="glyphicon glyphicon-floppy-disk"></span> Limpiar
                                </button>
                                <input id="id" name="id" type="hidden" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de usuarios -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Lista de usuarios
                </div>
                <div id="usuarios">
                </div>
            </div>
        </div>
        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/mustache.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {

                // Actualizar la lista de usuarios
                refrescarUsuarios();

                $('#boton-guardar').bind('click', function() {
                    var params = $('#frm-usuario').serializeArray();
                    params.push( {name: 'accion', value: 'guardar'} );

                    $.post('usuario_controller', 
                        params,
                        function(json) {
                            if ( json.resultado ) {
                                refrescarUsuarios();
                            } else {
                                // Mostrar error
                            }
                        });
                });
            });

            function refrescarUsuarios() {
                $.getJSON('usuario_controller.php', 
                    {accion: 'lista'}, 
                    function(json){
                        var tmpl = $('#usuarios_tmpl').html();
                        var res = Mustache.to_html(tmpl, json);
                        $('#usuarios').html(res);
                    });
            }

            function mostrarUsuario(idUsuario) {
                $.getJSON('usuario_controller.php', 
                    {accion: 'item', id: idUsuario},
                    function(json){
                        if ( json.resultado ) {
                            $('#id').attr('value', json.item.id);
                            $('#nombre').attr('value', json.item.nombre);
                            $('#paterno').attr('value', json.item.paterno);
                            $('#materno').attr('value', json.item.materno);
                            $('#nusuario').attr('value', json.item.usuario);
                            $('#contrasena').attr('value', json.item.contra);
                            $('#nombre').focus();
                        } else {
                            // Mostrar error
                        }
                    });
            }
        </script>
    </body>
</html>