<?php
require_once('../model/modelCustomer.php');
require_once('../model/uploadImg.php');

class ControllerCustomer extends modelCustomer
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
        require_once('../Views/customer/index.php');
    }

    public function searchCustomer($id, $name, $lastName)
    {
        $data = $this->searchCustomers($id, $name, $lastName);

        $this->resolve(false, 'OK', $data);
    }

    public function create()
    {
        $data = "";
        require_once("../views/customer/formCustomer.php");
    }

    public function save($typeSave, $name, $lastName, $email, $address, $tel, $user, $pass, $state, $img, $id="", $usua_id="")
    {
        if ($typeSave == "create") {
            $result = $this->createCustomer($name, $lastName, $email, $address, $tel, $user, $pass, $img, $state);
        } else if ($typeSave == "update") {
            $result = $this->updateCustomer($name, $lastName, $email, $address, $tel, $user, $pass, $usua_id, $id, $img, $state);
        } else {
            return false;
        }
        return $result;
    }

    public function update($customerId) 
    {
        $data = $this->searchCustomerById($customerId);
        $state = $data->UsEstado == 1 ? "Activo" : "Inactivo";
        require_once("../views/customer/formCustomer.php");
    }
}

$cCustomer = new ControllerCustomer;
$uploadImg = new UploadImg;

if (isset($_GET['action']) || isset($_POST['action'])) {
    $action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];

    $name = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $lastName = isset($_POST['apellido']) ? $_POST['apellido'] : "";
    $email = isset($_POST['correo']) ? $_POST['correo'] : "";
    $address = isset($_POST['direccion']) ? $_POST['direccion'] : "";
    $tel = isset($_POST['tel']) ? $_POST['tel'] : "";
    $user = isset($_POST['usuario']) ? $_POST['usuario'] : "";
    $pass = isset($_POST['clave']) ? $_POST['clave'] : "";
    $id = isset($_POST['clie_Id']) ? $_POST['clie_Id'] : ""; 
    $usua_id = isset($_POST['usua_Id']) ? $_POST['usua_Id'] : "";
    $state = isset($_POST['estado']) ? $_POST['estado'] : "";
    $file = isset($_FILES['fotoUsuario']['name']) ? $_FILES['FotoUsuario']['name'] : "";
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
            header('Location: controllerCustomer.php?action=create&message=' . $upload);
        }
    } else {
        $foto = $img == "" ? "users/sinfoto.jpg" : $img;
    }


    switch ($action) {
        case 'index':
            $cCustomer->index();
            break;
        case 'searchCustomer':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $name = $_GET['name'];
                $lastName = $_GET['lastName'];
                $cCustomer->searchCustomer($id, $name, $lastName);
            } else {
                echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
            }
            break;
        case 'create':
            $cCustomer->create();
            break;
        case 'saveCreate':
            $create = $cCustomer->save('create', $name, $lastName, $email, $address, $tel, $user, $pass, $state, $img);

            if ($create) {
                header('Location: controllerCustomer.php?action=index');
            } else {
                header('Location: controllerCustomer.php?action=create&message=error');
            }
            break;
        case 'update':
            $customerId = $_GET['id'];
            $cCustomer->update($customerId);
            break;
        case 'saveUpdate':
            $update = $cCustomer->save('update', $name, $lastName, $email, $address, $tel, $user, $pass, $state, $img, $id, $usua_id);

            if ($update) {
                header('Location: controllerCustomer.php?action=index');
            } else {
                header('Location: controllerCustomer.php?action=update&id=' . $id . '&message=error');
            }
            break;
    }
} else {
    echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
}
