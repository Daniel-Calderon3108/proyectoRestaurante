<?php
require_once("../Views/Menu.php");
if ($rol == "Cliente" || $rol == "Proveedor") {
    header('Location:Home.php');
}
?>
<title>DaCaAr System - Proveedor</title>
<section class="container_section">
    <div class="container_table">
        <h1>Listado de Proveedores</h1>
        <?php if ($rol == 'Administrador') { ?>
            <div class="btn_create">
                <a href="controllerProvider.php?action=create">Registrar nuevo proveedor</a>
            </div>
        <?php } ?>
        <form>
            <div class="container_search">
                <input type="hidden" value="<?= $rol ?>" id="rol">
                <input type="text" id="prov_Id" placeholder="ID">
                <input type="text" id="prov_Nombre" placeholder="Nombre">
                <input type="button" value="Buscar" class="btn_search" onclick="searchProvider()">
            </div>
        </form>
        <table id="tableProvider"></table>
        <p class="total"><span id="count"></span>-Total registros</p>
    </div>
</section>
<?php require_once('../Views/Footer.php') ?>
</body>
<script src="../Views/js/provider.js"></script>