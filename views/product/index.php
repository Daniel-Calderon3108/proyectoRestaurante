<?php
require_once("../Views/Menu.php");
if ($rol != "Proveedor") {
} else {
    header('Location:../Home.php');
}
?>
<title>DaCaAr System - Catalogo Productos</title>
<section class="container_section">
    <h2>Conoce los productos que tenemos especialmente para ti</h2>
    <!-- <p>Si quieres mas detalle, da click sobre el producto</p> -->
    <?php if ($rol == "Administrador") { ?>
        <div class="btn_admin_products">
            <a href="controllerProduct.php?action=admin">Administrar Productos</a>
        </div>
    <?php } ?>
    <div class="container_products">
       
        <?php
        foreach ($data as $products) {
            $Id = $products['prod_Id'];
            $nombre = $products['prod_Nombre'];
            $foto = $products['prod_Foto'];
            $descripcion = $products['prod_Descripcion'];
            $precio = $products['prod_Precio'];
        ?>
            <div class="body_products">
                <div class="products_text">
                    <p><?= $nombre ?></p>
                </div>
                <div class="products_img">
                    <img src="../views/img/<?= $foto ?>" class="product_img">
                </div>
                <div class="product_price">
                    <p>$ <?= number_format($precio) ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
<?php require_once('../Views/Footer.php') ?>