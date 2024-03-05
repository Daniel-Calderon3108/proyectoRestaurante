<?php
require_once('../Model/modelInventory.php');
require_once('../model/modelSelectors.php');
require_once('../model/uploadImg.php');

class ControllerInventory extends modelInventory
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
        require_once('../Views/inventory/index.php');
    }

    public function searchInventory($id,$inventory,$provider,$branch)
    {
        $data = $this->searchInventories($id,$inventory,$provider,$branch);

        $this->resolve(false,'OK',$data);
    }

    public function create()
    {
        $selector = new ModelSelectors;
        $data = "";
        $listSedes = $selector->selectorSede("", $this->conexion);
        require_once('../views/inventory/formInventory.php');
    }

    public function save($typeSave, $name, $state, $price, $quantity, $branch, $img, $id = "")
    {
        if ($typeSave == "create") {
            $result = $this->createInventory($name, $img, $price, $quantity, $branch, $state);
        } else if ($typeSave == "update") {
            $result = $this->updateInventory($name, $img, $price, $quantity, $branch, $state, $id);
        } else {
            return false;
        }

        return $result;
    }

    public function update($Inventoryid)
    {
        $result = $this->searchInventoryById($Inventoryid);
        $data = $result->record;
        $listSedes = $result->branch;
        $estado = $data->ingEstado == 1 ? "Activo" : "Inactivo";
        require_once('../views/inventory/formInventory.php');
    }
}

$cInventory = new ControllerInventory;
$uploadImg = new UploadImg;

if (isset($_GET['action']) || isset($_POST['action'])) {
    $action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];

    $name = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $state = isset($_POST['estado']) ? $_POST['estado'] : "";
    $price = isset($_POST['precio']) ? $_POST['precio'] : "";
    $quantity = isset($_POST['cantidad']) ? $_POST['cantidad'] : "";
    $branch = isset($_POST['sede']) ? $_POST['sede'] : "";
    $file = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : "";
    $id = isset($_POST['ing_Id']) ? $_POST['ing_Id'] : "";
    $img = isset($_POST['imgInventario']) ? $_POST['imgInventario'] : "";
    $foto = "";
    
    if (isset($file) && $file != "") {

        $extension = $_FILES['foto']['type'];
        $size = $_FILES['foto']['size'];
        $temp = $_FILES['foto']['tmp_name'];

        $upload = $uploadImg->upload($file, $extension, $size, $temp, 'inventory');

        if ($upload) {
            $foto = "inventory/" . $file;
        } else {
            header('Location: controllerInventory.php?action=create&message=' . $upload);
        }
    } else {
        $foto = $img == "" ? "users/sinfoto.jpg" : $img;
    }
    
    switch ($action) {
        case 'index':
            $cInventory->index();
            break;
        case 'searchInventory':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $inventory = $_GET['inventory'];
                $provider = $_GET['provider'];
                $branch = $_GET['branch'];
                $cInventory->searchInventory($id,$inventory,$provider,$branch);
            } else {
                echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';            
            }
            break;
        case 'create':
            $cInventory->create();
            break;
        case 'saveCreate':
            $create = $cInventory->save('create', $name, $state, $price, $quantity, $branch, $foto);

            if ($create) {
                header('Location: controllerInventory.php?action=index');
            } else {
                header('Location: controllerInventory.php?action=create&message=error');
            }
            break;
        case 'update':
            $inventoryId = $_GET['id'];
            $cInventory->update($inventoryId);
            break;
        case 'saveUpdate':
            $update = $cInventory->save('update', $name, $state, $price, $quantity, $branch, $foto, $id);

            if ($update) {
                header('Location: controllerInventory.php?action=index');
            } else {
                header('Location: controllerInventory.php?action=update&id=' . $id . '&message=error');
            }
            break;
    }
} else {
    echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
}
