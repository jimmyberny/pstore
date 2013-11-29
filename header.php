<?php 
require_once( 'admin.php' );
$usr = $_SESSION['usuario'];
$nom = sprintf( '%s %s %s', $usr['nombre'], $usr['paterno'], $usr['materno'] );
?>
<script type="text/javascript">
	function salir(){
		$.post('login.php',
			{accion: 'logout'},
			function(json) {
				if (json.resultado) {
					document.location = 'index.php';
				} else {
					alert('No se puede cerrar la sesión');
				}
			});
	}
</script>
<div class="navbar navbar-fixed-top navbar-inverse">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
          	</button>
			<a class="navbar-brand" href="#">Papelería</a>
		</div>
		<div class="navbar-collapse collapse">
			<?php include 'menu.php' ?>
			<ul class="nav navbar-nav pull-right">
				<li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $nom; ?></a></li>
				<li><a onclick="salir();"><span class="glyphicon glyphicon-off"></span></a></li>
			</ul>
		</div>
	</div>
</div>