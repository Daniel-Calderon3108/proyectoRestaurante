<?php
require_once('../Views/Menu.php');
if ($rol == "Proveedor") {
    header('Location:../Views/Home.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Views/img/icono.jpg" type="image/x-icon">
    <link rel="stylesheet" href="../Views/css/estilos.css">
    <title>DaCaAr System - Pedido</title>
</head>

<body>
    <section class="container_section">
        <div class="container_table">
            <h1>Listado de Pedidos</h1>
            <?php if ($rol != "Proveedor") { ?>
                <div class="btn_create">
                    <a href="FormPedido.php">Registrar nuevo pedido</a>
                </div>
            <?php } ?>
            <form>
                <div class="container_search">
                    <input type="hidden" value="<?= $rol ?>" id="rol">
                    <input type="text" id="Id" placeholder="ID">
                    <input type="text" id="customerName" placeholder="Nombre Cliente">
                    <input type="text" id="customerLastName" placeholder="Apellido Cliente">
                    <input type="date" id="fecha" value="<?= $fecha ?>">
                    <input type="button" value="Buscar" class="btn_search" onclick="searchOrder()">
                </div>
                <table id="tableOrder"></table>
                <p class="total"><span id="count"></span>-Total registros</p>
            </form>
        </div>
    </section>
    <?php require_once('../Views/Footer.php') ?>
</body>
<script src="../Views/js/order.js"></script>
</html>