<title>DaCaAr System - <?= $data == "" ? "Creando" :  "Editando" ?> Proveedor</title>
<?php require_once("../Views/Menu.php") ?>
<section class="container_section">
    <div class="container_form">
        <h2><?= $data == "" ? "Creando" : "Editando" ?> Proveedor</h2>
        <h3>Datos Proveedor</h3>
        <form action="controllerProvider.php" class="container_forms" method="POST" enctype="multipart/form-data">
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="nombre" placeholder="Nombre" value="<?= $data == "" ? "" : $data->prov_Nombre; ?>">
                    <input type="hidden" name="prov_Id" value="<?= $data == "" ? null :  $data->prov_Id; ?>">
                </div>
            </div>
            <div class="form_item">
            <div class="form_body">
                    <select name="tipo_documento" id="tipo_documento" class="form_input">
                        <option value="<?= $data == "" ? "" :  $data->id_tipo ?>"><?= $data == "" ? "Seleccione tipo documento" :  $data->tipo ?></option>
                        <?php foreach ($listTipoDocumento as $list) {
                            $idTipo = $list['id_tipo'];
                            $tipo = $list['tipo'];
                        ?>
                            <option value="<?= $idTipo; ?>"><?= $tipo; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form_body form_document">
                    <input type="text" class="form_input" name="documento" placeholder="Documento" value="<?= $data == "" ? "" :  $data->prov_Documento; ?>">
                </div>
            </div>
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="tel" placeholder="Celular" value="<?= $data == "" ? "" :  $data->prov_Telefono; ?>">
                </div>
                <div class="form_body">
                    <input type="text" class="form_input" name="correo" placeholder="Correo Electronico" value="<?= $data == "" ? "" :  $data->prov_Correo; ?>">
                </div>
            </div>
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="link" placeholder="Link Página (opcional)" value="<?= $data == "" ? "" :  $data->prov_Link_Pagina; ?>">
                </div>
            </div>
            <h3>Datos Usuario</h3>
            <div class="form_item">
                <div class="form_body">
                    <input type="text" class="form_input" name="usuario" placeholder="Usuario" value="<?= $data == "" ? "" :  $data->usua_Nombre; ?>">
                    <input type="hidden" name="usua_Id" value="<?= $data == "" ? "" :  $data->usua_Id; ?>">
                </div>
            </div>
            <div class="form_item">
                <div class="form_body">
                    <input type="password" class="form_input" name="clave" placeholder="Clave" value="<?= $data == "" ? "" :  $data->usua_Clave; ?>">
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
                            <option value="<?= $data->UsEstado ?>"><?= $estado ?></option>
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