<?php 
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="shortcut icon" href=""> -->
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-theme.css">
        <link rel="stylesheet" href="css/login.css">

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
							<div class="input-group">
								<input type="text" class="form-control" />
								<span class="input-group-btn">
									<button type="button" class="btn btn-default">
										<span class="glyphicon glyphicon-flash"></span>
									</button>
								</span>
							</div>
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
							<button id="boton-actualizar" class="btn btn-default" type="button">
								<span class="glyphicon glyphicon-refresh"> </span>
							</button>
							<strong>Ticket actual</strong>
							<div class="btn-group pull-right">
								<button id="boton-vender" class="btn btn-default" type="button">
									<span class="glyphicon glyphicon-ok"></span> Vender
								</button>
							</div>
						</div>
						<div id="lista-lineas" class="lista-items">
						</div>
					</div>
				</div>
				<!-- Termina panel ticket -->
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
            });
        </script>
	</body>
</html>