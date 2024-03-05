<?php
require_once('../Views/Menu.php');
if ($rol == 'Cliente') {
    header('Location:../Views/Home.php');
}
?>
<title>DaCaAr System - Sede</title>
<section class="container_section">
    <div class="container_table">
        <h1>Listado de Sedes</h1>
        <?php if ($rol == "Administrador" || $rol == "Proveedor") { ?>
            <div class="btn_create">
                <a href="controllerBranch.php?action=create">Registrar nueva sede</a>
            </div>
        <?php } ?>
        <form>
            <div class="container_search">
                <input type="hidden" value="<?= $rol ?>" id="rol">
                <input type="text" id="sede_Id" placeholder="ID">
                <input type="text" id="sede_Nombre" placeholder="Nombre">
                <input type="button" value="Buscar" class="btn_search" onclick="searchBranch()">
            </div>
            <table id="tableBranch"></table>
            <p class="total"><span id="count"></span>-Total registros</p>
        </form>
    </div>
</section>
<?php require_once('../Views/Footer.php') ?>
<script src="../Views/js/branch.js"></script>