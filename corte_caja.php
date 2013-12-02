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

        <title>Cerrar de caja</title>
    </head>
    <body>
        <!-- Empieza el encabezado -->
        <?php include 'header.php' ?>
        <!-- Termina el encabezado -->

        <!-- Contenido -->
        <div class="container">
            <h1>Cerrar caja</h1>
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
                <div class="form-group">
                    <div class="col-lg-2 col-lg-offset-8">
                        <button id="btn-act-caja" class="btn btn-block btn-default" type="button" onclick="actualizarInfo()" >
                            <span class="glyphicon glyphicon-repeat"></span> Actualizar
                        </button>
                    </div>
                    <div class="col-lg-2">
                        <button id="btn-cerrar-caja" class="btn btn-block btn-primary" type="button" onclick="cerrarCaja()" >
                            <span class="glyphicon glyphicon-usd"></span> Cerrar caja
                        </button>
                    </div>
                </div>
            </form>
            <div id="mensajes">
                <!-- aqui se muestran los mensajes -->
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
                // Cargar información de la caja actual
                actualizarInfo(); 
            });

            function actualizarInfo() {
                $.post('corte_caja_ctrl.php', 
                    {accion: 'consultar'},
                    function( json ) {
                        if ( json.resultado ) {
                            $('#inicio').val( json.inicio );
                            $('#fin').val( json.fin );
                            $('#total').val( json.total );

                            if ( json.cerrar ) {
                                $('#btn-cerrar-caja').removeAttr('disabled');
                            } else {
                                $('#btn-cerrar-caja').attr('disabled', true);
                            }
                        } else {
                            uxErrorAlert( json.error );
                        }
                    });
            }

            function cerrarCaja() {
                $.post('corte_caja_ctrl.php',
                    {accion: 'cerrar'},
                    function(json) {
                        if ( json.resultado ) {
                            // Deshabilitar el boton
                            $('#btn-cerrar-caja').attr('disabled', true);
                            // Mostrar fecha final
                            $('#fin').val( json.fin );
                            uxSuccessAlert( json.mensaje );
                        } else {
                            uxErrorAlert( json.error );
                        }
                    });
            }
        </script>
    </body>
</html>