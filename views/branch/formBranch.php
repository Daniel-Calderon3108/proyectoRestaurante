<title>DaCaAr System - <?= $data == "" ? "Creando" :  "Editando" ?> Sede</title>
<?php require_once("../Views/Menu.php") ?>
<section class="container_section">
    <div class="container_form">
        <h2><?= $data == "" ? "Creando" : "Editando" ?> Sede</h2>
        <h3>Datos Sede</h3>
        <form action="controllerBranch.php" class="container_forms" method="POST">
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="nombre" placeholder="Nombre" value="<?= $data == "" ? "" : $data->sede_Nombre ?>">
                    <input type="hidden" name="sede_Id" value="<?= $data == "" ? null :  $data->sede_Id ?>">
                </div>
                <div class="form_body">
                    <select name="estado" id="estado" class="form_input">
                        <?php if ($data != "") { ?>
                            <option value="<?= $data->sedeEstado ?>"><?= $estado ?></option>
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
                    <select name="ciudad" id="" class="form_input">
                        <option value="<?= $data == "" ? "" :  $data->ciud_Id ?>"><?= $data == "" ? "Seleccione ciudad" :  $data->ciud_Nombre ?></option>
                        <?php foreach ($listCiudad as $ciudad) {
                            $dataCiudad = $ciudad['ciud_Id'];
                            $ciudadNombre = $ciudad['ciud_Nombre'];
                            $pais = $ciudad['pais_Nombre'];
                        ?>
                            <option value="<?= $dataCiudad; ?>"><?= $ciudadNombre . ", " . $pais ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form_body">
                    <select name="proveedor" id="" class="form_input">
                        <option value="<?= $data == "" ? "" :  $data->prov_Id ?>"><?= $data == "" ? "Seleccione proveedor" :  $data->prov_Nombre ?></option>
                        <?php foreach ($listProveedor as $proveedor) {
                            $dataProveedor = $proveedor['prov_Id'];
                            $proveedorNombre = $proveedor['prov_Nombre'];
                        ?>
                            <option value="<?= $dataProveedor ?>"><?= $proveedorNombre ?></option>
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