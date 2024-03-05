<title>DaCaAr System - Inventario</title>
<?php
require_once('../Views/Menu.php');
if ($rol == "Cliente") {
    header('Location:../Views/Home.php');
}
?>
<section class="container_section">
    <div class="container_table">
        <h1>Listado de Inventario</h1>
        <?php if ($rol == "Administrador" || $rol == "Proveedor") { ?>
            <div class="btn_create">
                <a href="controllerInventory.php?action=create">Registrar nuevo inventario</a>
            </div>
        <?php } ?>
        <form>
            <div class="container_search">
                <input type="hidden" value="<?= $rol ?>" id="rol">
                <input type="text" id="detIng_Id" placeholder="ID">
                <input type="text" id="ing_Nombre" placeholder="Producto">
                <input type="text" id="prov_Nombre" placeholder="Proveedor">
                <input type="text" id="sede_Nombre" placeholder="Sede">
                <input type="button" value="Buscar" class="btn_search" onclick="searchInventory()">
            </div>
            <table id="tableInventory"></table>
            <p class="total"><span id="count"></span>-Total registros</p>
        </form>
    </div>
</section>
<?php require_once('../Views/Footer.php') ?>
<script src="../Views/js/inventory.js"></script>