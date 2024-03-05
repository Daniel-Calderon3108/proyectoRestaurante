<?php
require_once('../Views/Menu.php');
?>
<title>DaCaAr System - Ciudades</title>
<section class="container_section">
    <div class="container_table">
        <h1>Listado de Ciudades</h1>
        <?php if ($rol == "Administrador") { ?>
            <div class="btn_create">
                <a href="controllerCity.php?action=create">Registrar nueva ciudad</a>
            </div>
        <?php } ?>
        <form>
            <div class="container_search">
                <input type="hidden" value="<?= $rol ?>" id="rol">
                <input type="text" id="ciud_Id" placeholder="ID">
                <input type="text" id="ciud_Nombre" placeholder="Ciudad">
                <input type="text" id="pais_Nombre" placeholder="País">
                <input type="button" value="Buscar" class="btn_search" onclick="searchCity()">
            </div>
            <table id="tableCity"></table>
            <p class="total"><span id="count"></span>-Total registros</p>
        </form>
    </div>
</section>
<?php require_once('../Views/Footer.php') ?>
<script src="../Views/js/city.js"></script>