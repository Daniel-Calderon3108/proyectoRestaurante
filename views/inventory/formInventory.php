<title>DaCaAr System - <?= $data == "" ? "Añadiendo" :  "Editando" ?> Inventario</title>
<?php require_once("../Views/Menu.php") ?>
<section class="container_section">
    <div class="container_form">
        <h2><?= $data == "" ? "Añadiendo" : "Editando" ?> Inventario</h2>
        <h3>Datos Inventario</h3>
        <form action="controllerInventory.php" class="container_forms" method="POST" enctype="multipart/form-data">
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="nombre" placeholder="Nombre" value="<?= $data == "" ? "" : $data->ing_Nombre ?>">
                    <input type="hidden" name="ing_Id" value="<?= $data == "" ? null :  $data->detIng_Id ?>">
                </div>
                <div class="form_body">
                    <select name="estado" id="estado" class="form_input">
                        <?php if ($data != "") { ?>
                            <option value="<?= $data->ingEstado ?>"><?= $estado ?></option>
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
                    <input type="text" class="form_input" name="precio" placeholder="Precio sin comas ni puntos" value="<?= $data == "" ? "" : $data->detIng_precio ?>">
                </div>
                <div class="form_body">
                    <input type="file" class="form_input" name="foto">
                    <input type="hidden" name="imgInventario" value="<?= $data == "" ? "" : $data->ing_Foto ?>">
                </div>
            </div>
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="cantidad" placeholder="Cantidad" value="<?= $data == "" ? "" : $data->detIng_cantidad ?>">
                </div>
                <div class="form_body">
                    <select name="sede" id="" class="form_input">
                        <option value="<?= $data == "" ? "" :  $data->sede_Id ?>"><?= $data == "" ? "Seleccione Sede" :  $data->sede_Nombre ?></option>
                        <?php foreach ($listSedes as $list) {
                            $idSede = $list['sede_Id'];
                            $sede = $list['sede_Nombre'];
                            $ciudad = $list['ciud_Nombre'];
                        ?>
                            <option value="<?= $idSede; ?>"><?= $sede . ', ' . $ciudad ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form_item">
                <div class="form_body">
                    <input type="hidden" name="action" value="<?= $data == "" ? "saveCreate" : "saveUpdate" ?>">
                    <input type="submit" value="<?= $data == "" ? "Añadir" : "Guardar" ?>" class="form_button">
                </div>
            </div>
        </form>
    </div>
</section>
<?php require_once('../Views/Footer.php') ?>