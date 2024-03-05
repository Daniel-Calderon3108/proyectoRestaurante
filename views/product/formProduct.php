<title>DaCaAr System - <?= $data == "" ? "Creando" :  "Editando" ?> Producto</title>
<?php
require_once('../Views/Menu.php');
if ($rol != "Administrador") {
    header('Location:../Home.php');
}
?>
<section class="container_section">
    <div class="container_form">
        <h2><?= $data == "" ? "Creando" : "Editando" ?> Producto</h2>
        <h3>Datos producto</h3>
        <form action="controllerProduct.php" class="container_forms" method="POST" enctype="multipart/form-data">
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="nombre" placeholder="Nombre" value="<?= $data == "" ? "" : $data->prod_Nombre ?>">
                    <input type="hidden" name="prod_Id" value="<?= $data == "" ? null :  $data->prod_Id ?>">
                </div>
                <div class="form_body">
                    <select name="estado" id="estado" class="form_input">
                        <?php if ($data != "") { ?>
                            <option value="<?= $data->prodEstado ?>"><?= $estado ?></option>
                            <?php if ($estado == "Activo") { ?>
                                <option value="0">Inactivo</option>
                            <?php } else { ?>
                                <option value="1">Activo</option>
                            <?php  }
                        } else { ?>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="precio" placeholder="Precio sin comas ni puntos" value="<?= $data == "" ? "" : $data->prod_Precio ?>">
                </div>
                <div class="form_body">
                    <input type="file" class="form_input" name="foto">
                    <input type="hidden" name="imgProduct" value="<?= $data == "" ? "" : $data->prod_Foto ?>">
                </div>
            </div>
            <div class="form_item">
                <div class="form_body">
                    <textarea name="descripcion" class="form_input" placeholder="Breve descripción del producto"><?= $data == "" ? "" : $data->prod_Descripcion ?></textarea>
                </div>
            </div>
            <div class="form_item">
                <div class="form_body">
                <input type="hidden" name="action" value="<?= $data == "" ? "saveCreate" : "saveUpdate" ?>">
                    <input type="submit" value="<?= $data == "" ? "Registrar" : "Editar" ?>" class="form_button">
                </div>
            </div>
        </form>
    </div>
</section>
<?php require_once('../Views/Footer.php') ?>