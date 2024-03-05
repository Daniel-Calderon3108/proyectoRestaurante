<title>DaCaAr System - Empleado</title>
<?php require_once("../Views/Menu.php"); ?>
<section class="container_section">
	<div class="container_table">
		<h1>Listado de Empleados</h1>
		<div class="btn_create">
			<a href="controllerEmployee.php?action=create">Registrar nuevo empleado</a>
		</div>
		<form>
			<div class="container_search">
				<input type="text" id="empl_Id" placeholder="ID">
				<input type="text" id="empl_Nombre" placeholder="Nombre">
				<input type="text" id="empl_Apellido" placeholder="Apellido">
				<input type="button" value="Buscar" class="btn_search" onclick="searchEmployee()">
			</div>
		</form>
		<div style="overflow-y: auto;"><table id="tableEmployee"></table></div>
		<p class="total"><span id="count"></span>-Total registros</p>
	</div>
</section>
<?php require_once('../Views/Footer.php') ?>
<script src="../Views/js/employee.js"></script>