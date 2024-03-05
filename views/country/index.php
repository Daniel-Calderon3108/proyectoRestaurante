<?php require_once('../Views/Menu.php') ?>
<title>DaCaAr System - Paises</title>
<section class="container_section">
    <div class="container_table">
        <h1>Listado de Paises</h1>
        <?php if ($rol == "Administrador") { ?>
            <div class="btn_create">
                <a href="controllerCountry.php?action=create">Registrar nuevo país</a>
            </div>
        <?php } ?>
        <form>
            <div class="container_search">
                <input type="hidden" value="<?= $rol ?>" id="rol">
                <input type="text" id="pais_Id" placeholder="ID">
                <input type="text" id="pais_Nombre" placeholder="Nombre">
                <input type="button" value="Buscar" class="btn_search" onclick="searchCountry()">
            </div>
            <table id="tableCountry"></table>
            <p class="total"><span id="count"></span>-Total registros</p>
        </form>
    </div>
</section>
<?php require_once('../Views/Footer.php') ?>
<script src="../Views/js/country.js"></script>