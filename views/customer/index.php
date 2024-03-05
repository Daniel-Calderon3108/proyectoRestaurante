<title>DaCaAr System - Cliente</title>
<?php require_once("../Views/Menu.php"); ?>
<section class="container_section">
    <div class="container_table">
        <h1>Listado de Clientes</h1>
        <div class="btn_create">
            <a href="controllerCustomer.php?action=create">Registrar Nuevo Cliente</a>
        </div>
        <form>
            <div class="container_search">
                <input type="text" id="clie_Id" placeholder="ID">
                <input type="text" id="clie_Nombre" placeholder="Nombre">
                <input type="text" id="clie_Apellido" placeholder="Apellido">
                <input type="hidden" value="<?= $rol ?>" id="rol">
                <input type="button" value="Buscar" class="btn_search" onclick="searchCustomer()">
            </div>
        </form>
        <table id="tableCustomer"></table>
        <p class="total"><span id="count"></span>-Total registros</p>
    </div>
</section>
<?php require_once('../Views/Footer.php') ?>
<script src="../Views/js/customer.js"></script>