<?php 
#Aqui va el menú
?>
<ul class="nav navbar-nav">
	<li class="active"><a href="#">Inicio</a></li>
	<li class="dropdown">
		<!-- Es un menu con submenues -->
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Administración<b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><a href="usuarios.php">Usuarios</a></li>
			<li><a href="roles.php">Roles</a></li>
			<li><a href="clientes.php">Clientes</a></li>
		</ul>
	</li>
	<li class="dropdown">
		<!-- Es un menu con submenues -->
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Inventario<b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><a href="categorias.php">Categorias</a></li>
			<li><a href="producto.php">Productos</a></li>
		</ul>
	</li>
</ul>

