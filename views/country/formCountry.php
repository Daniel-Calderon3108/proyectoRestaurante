<title>DaCaAr System - <?= $data == "" ? "Creando" :  "Editando" ?> País</title>

<?php require_once("../Views/Menu.php") ?>
<section class="container_section">
    <div class="container_form">
        <h2><?= $data == "" ? "Creando" : "Editando" ?> País</h2>
        <h3>Datos País</h3>
        <form action="controllerCountry.php" class="container_forms" method="POST" enctype="multipart/form-data">
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="nombre" placeholder="Nombre" value="<?= $data == "" ? "" : $data->pais_Nombre; ?>">
                    <input type="hidden" name="pais_Id" value="<?= $data == "" ? null :  $data->pais_Id; ?>">
                </div>
            </div>
            <div class="form_item">
                <div class="form_body">
                    <select name="estado" id="estado" class="form_input">
                        <?php if ($data != "") { ?>
                            <option value="<?= $data->paisEstado ?>"><?= $estado ?></option>
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
                <div class="form_body">
                    <input type="file" class="form_input" name="bandera">
                    <input type="hidden" name="imgBandera" value="<?= $data == "" ? "" : $data->bandera ?>">
                </div>
            </div>
            <?php if ($data == "") { ?>
                <h3>Datos Ciudad</h3>
                <div class="form_item">
                    <div class="form_body">
                        <input type="text" name="ciudad" id="" class="form_input" placeholder="Ciudad">
                    </div>
                    <div class="form_body">
                        <select name="estadoCiudad" id="estadoCiudad" class="form_input">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
            <?php } ?>
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