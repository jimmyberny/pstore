<!DOCTYPE html>
<html lang="es">
	<!-- Aqui esta el login -->
	<head>
		<meta charset="uft-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="shortcut icon" href=""> -->
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-theme.css">
        <link rel="stylesheet" href="css/login.css">

        <title>Bienvenido al sistema</title>
	</head>
	<body>
		<div class="container">
			<h1>Bienvenido</h1>
			<form action="home.php">
				<h2>Ingresar al sistema</h2>
				<input type="text" class="form-control" placeholder="Usuario">
				<input type="password" class="form-control" placeholder="Contraseña">
				<button class="btn btn-primary btn-block" type="submit">Entrar</button>
			</form>
		</div>

		<!-- Empieza javascript -->
		<script src="js/jquery-1.10.2.js"></script>
        <script src="js/bootstrap.js"></script>
		<!-- Termina javascript -->
	</body>
</html>