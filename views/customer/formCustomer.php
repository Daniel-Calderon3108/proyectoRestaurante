<title>DaCaAr System - <?= $data == "" ? "Creando" :  "Editando" ?> Cliente</title>
<?php require_once("../Views/Menu.php") ?>
<section class="container_section">
    <div class="container_form">
        <h2><?= $data == "" ? "Creando" : "Editando" ?> Cliente</h2>
        <h3>Datos Cliente</h3>
        <form action="controllerCustomer.php" class="container_forms" method="POST">
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="nombre" placeholder="Nombre" value="<?= $data == "" ? "" : $data->clie_Nombre ?>">
                    <input type="hidden" name="clie_Id" value="<?= $data == "" ? null :  $data->clie_Id ?>">
                </div>
                <div class="form_body">
                    <input type="text" class="form_input" name="apellido" placeholder="Apellido" value="<?= $data == "" ? "" :  $data->clie_Apellido ?>">
                </div>
            </div>
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="correo" placeholder="Correo Electronico" value="<?= $data == "" ? "" :  $data->clie_Correo ?>">
                </div>
                <div class="form_body">
                    <input type="text" class="form_input" name="tel" placeholder="Celular" value="<?= $data == "" ? "" :  $data->clie_Celular ?>">
                </div>
            </div>
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="direccion" placeholder="Dirección" value="<?= $data == "" ? "" :  $data->clie_Direccion ?>">
                </div>
            </div>
            <h3>Datos Usuario</h3>
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="usuario" placeholder="Usuario" value="<?= $data == "" ? "" :  $data->usua_Nombre ?>">
                    <input type="hidden" name="usua_Id" value="<?= $data == "" ? "" :  $data->usu_Id ?>">
                </div>
            </div>
            <div class="form_item">
                <div class="form_body">
                    <input type="password" class="form_input" name="clave" placeholder="Clave" value="<?= $data == "" ? "" :  $data->usua_Clave ?>">
                </div>
            </div>
            <div class="form_item">
                <div class="form_body">
                    <label for="">Foto Usuario</label>
                    <input type="file" class="form_input" name="fotoUsuario">
                    <input type="hidden" name="imgUsuario" value="<?= $data == "" ? "" : $data->usua_foto ?>">
                </div>
                <div class="form_body">
                    <label for="">Estado</label>
                    <select name="estado" id="estado" class="form_input">
                        <?php if ($data != "") { ?>
                            <option value="<?= $data->UsEstado ?>"><?= $state ?></option>
                            <?php if ($state == "Activo") { ?>
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