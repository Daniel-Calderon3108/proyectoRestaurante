<?php
require_once('../Model/modelProvider.php');
require_once('../model/modelSelectors.php');
require_once('../model/uploadImg.php');

class ControllerProvider extends modelProvider
{
    public function resolve($error, $message, $data = null)
    {
        $data = array(
            'error' => $error,
            'message' => $message,
            'data' => $data
        );
        $json = json_encode($data);
        header('Content-Type: application/json');

        echo $json;
    }

    public function index()
    {
        require_once('../Views/provider/index.php');
    }

    public function searchProvider($id, $name)
    {
        $data = $this->searchProviders($id, $name);

        $this->resolve(false, 'OK', $data);
    }

    public function create()
    {
        $selector = new ModelSelectors;
        $data = "";
        $listTipoDocumento = $selector->selectorTipoDocumento("", $this->conexion);
        require_once("../views/provider/formProvider.php");
    }

    public function save($typeSave, $name, $type, $document, $email, $tel, $link, $user, $pass, $state, $img, $usua_id = "", $id = "")
    {

        if ($typeSave == "create") {
            $result = $this->createProvider($name, $type, $document, $email, $tel, $link, $user, $pass, $state, $img);
        } else if ($typeSave == "update") {
            $result = $this->updateProvider($name, $type, $document, $email, $tel, $link, $user, $pass, $usua_id, $id, $state, $img);
        } else {
            return false;
        }

        return $result;
    }

    public function update($providerId)
    {
        $result = $this->searchProviderById($providerId);
        $data = $result->record;
        $listTipoDocumento = $result->typeDocument;
        $estado = $data->UsEstado == 1 ? 'Activo' : 'Inactivo';
        require_once('../views/provider/formProvider.php');
    }
}

$cProvider = new ControllerProvider;
$uploadImg = new UploadImg;

if (isset($_GET['action']) || isset($_POST['action'])) {
    $action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];

    $name = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $type = isset($_POST['tipo_documento']) ? $_POST['tipo_documento'] : "";
    $document = isset($_POST['documento']) ? $_POST['documento'] : "";
    $email = isset($_POST['correo']) ? $_POST['correo'] : "";
    $tel = isset($_POST['tel']) ? $_POST['tel'] : "";
    $link = isset($_POST['link']) ? $_POST['link'] : "";
    $user = isset($_POST['usuario']) ? $_POST['usuario'] : "";
    $pass = isset($_POST['clave']) ? $_POST['clave'] : "";
    $usua_id = isset($_POST['usua_Id']) ? $_POST['usua_Id'] : "";
    $id = isset($_POST['prov_Id']) ? $_POST['prov_Id'] : "";
    $state = isset($_POST['estado']) ? $_POST['estado'] : "";
    $file = isset($_FILES['fotoUsuario']['name']) ? $_FILES['fotoUsuario']['name'] : "";
    $img = isset($_POST['imgUsuario']) ? $_POST['imgUsuario'] : "";
    $foto = "";

    if (isset($file) && $file != "") {

        $extension = $_FILES['fotoUsuario']['type'];
        $size = $_FILES['fotoUsuario']['size'];
        $temp = $_FILES['fotoUsuario']['tmp_name'];

        $upload = $uploadImg->upload($file, $extension, $size, $temp, 'users');

        if ($upload) {
            $foto = "users/" . $file;
        } else {
            header('Location: controllerProvider.php?action=create&message=' . $upload);
        }
    } else {
        $foto = $img == "" ? "users/sinfoto.jpg" : $img;
    }

    switch ($action) {
        case 'index':
            $cProvider->index();
            break;
        case 'searchProvider':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $name = $_GET['name'];
                $cProvider->searchProvider($id, $name);
            } else {
                echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
            }
            break;
        case 'create':
            $cProvider->create();
            break;
        case 'saveCreate':
            $create = $cProvider->save('create', $name, $type, $document, $email, $tel, $link, $user, $pass, $state, $foto);

            if ($create) {
                header('Location: controllerProvider.php?action=index');
            } else {
                header('Location: controllerProvider.php?action=create&message=error');
            }
            break;
        case 'update':
            $providerId = $_GET['id'];
            $cProvider->update($providerId);
            break;
        case 'saveUpdate':
            $update = $cProvider->save('update', $name, $type, $document, $email, $tel, $link, $user, $pass, $state, $foto, $usua_id, $id);

            if ($update) {
                header('Location: controllerProvider.php?action=index');
            } else {
                header('Location: controllerProvider.php?action=update&id=' . $id . '&message=error');
            }
            break;
    }
} else {
    echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
}
