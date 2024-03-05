<title>DaCaAr System - <?= $data == "" ? "Creando" :  "Editando" ?> Ciudad</title>
<?php require_once("../Views/Menu.php") ?>
<section class="container_section">
    <div class="container_form">
        <h2><?= $data == "" ? "Creando" : "Editando" ?> Ciudad</h2>
        <h3>Datos Ciudad</h3>
        <form action="controllerCity.php" class="container_forms" method="POST">
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="nombre" placeholder="Nombre" value="<?= $data == "" ? "" : $data->ciud_Nombre; ?>">
                    <input type="hidden" name="ciud_Id" value="<?= $data == "" ? null :  $data->ciud_Id; ?>">
                </div>
            </div>
            <div class="form_item">
                <div class="form_body">
                    <select name="pais" id="" class="form_input">
                        <option value="<?= $data == "" ? "" :  $data->pais_Id ?>"><?= $data == "" ? "Seleccione pais" :  $data->pais_Nombre ?></option>
                        <?php foreach($listCountry as $list) {
                            $idPais = $list['pais_Id'];
                            $pais = $list['pais_Nombre'];
                        ?>
                            <option value="<?= $idPais ?>"><?= $pais ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form_body">
                    <select name="estado" id="estado" class="form_input">
                        <?php if ($data != "") { ?>
                            <option value="<?= $data->ciudEstado ?>"><?= $estado ?></option>
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
                <input type="hidden" name="action" value="<?= $data == "" ? "saveCreate" : "saveUpdate" ?>">
                    <input type="submit" value="<?= $data == "" ? "Registrar" : "Editar" ?>" class="form_button">
                </div>
            </div>
        </form>
    </div>
</section>
<?php require_once('../Views/Footer.php') ?>