<?php
require_once('../Views/Menu.php');
if ($rol != "Administrador") {
    header('Location:Home.php');
}
?>
<title>DaCaAr System - Producto</title>
<section class="container_section">
    <div class="container_table">
        <h1>Administrar Productos</h1>
        <div class="btn_create">
            <a href="controllerProduct.php?action=create">Registrar nuevo producto</a>
        </div>
        <form>
            <div class="container_search">
                <input type="hidden" value="<?= $rol ?>" id="rol">
                <input type="text" id="id" placeholder="ID">
                <input type="text" id="nombre" placeholder="Nombre Producto">
                <input type="button" value="Buscar" class="btn_search" onclick="searchProduct()">
            </div>
            <table id="tableProduct"></table>
            <p class="total"><span id="count"></span>-Total registros</p>
        </form>
    </div>
</section>
<?php require_once('../Views/Footer.php') ?>
<script src="../Views/js/product.js"></script>