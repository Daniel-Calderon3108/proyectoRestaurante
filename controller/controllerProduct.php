<?php

require_once('../model/modelProduct.php');
require_once('../model/modelSelectors.php');
require_once('../model/uploadImg.php');

class ControllerProduct extends modelProduct
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
        $data = $this->searchProducts("","");
        require_once('../views/product/index.php');
    }

    public function admin()
    {
        require_once('../views/product/admin.php');
    }

    public function searchProduct($id, $name)
    {
        $data = $this->searchProducts($id, $name);

        $this->resolve(false,'OK',$data);
    }

    public function create()
    {
        $data = "";
        require_once('../views/product/formProduct.php');
    }

    public function save($typeSave, $name, $description, $price, $state, $img, $prodId = "")
    {
        if ($typeSave == 'create') {
            $result = $this->createProduct($name, $img, $description, $price, $state);
        } else if ($typeSave == 'update') {
            $result = $this->updateProduct($name, $img, $description, $price, $prodId, $state);
        } else {
            return false;
        }

        return $result;
    }

    public function update($prodId)
    {
        $data = $this->searchProductById($prodId);
        $estado = $data->prodEstado == 1 ? "Activo" : "Inactivo";
        require_once('../views/product/formProduct.php');
    }
}

$cProduct = new ControllerProduct;
$uploadImg = new UploadImg;

if (isset($_GET['action']) || isset($_POST['action'])) {

    $name = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $description = isset($_POST['descripcion']) ? $_POST['descripcion'] : "";
    $price = isset($_POST['precio']) ? $_POST['precio'] : "";
    $prodId =isset($_POST['prod_Id']) ? $_POST['prod_Id'] : "";
    $state = isset($_POST['estado']) ? $_POST['estado'] : "";
    $file = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : "";
    $img = isset($_POST['imgProduct']) ? $_POST['imgProduct'] : "";
    $foto = "";

    if (isset($file) && $file != "") {

        $extension = $_FILES['foto']['type'];
        $size = $_FILES['foto']['size'];
        $temp = $_FILES['foto']['tmp_name'];

        $upload = $uploadImg->upload($file, $extension, $size, $temp, 'products');

        if ($upload) {
            $foto = "products/" . $file;
        } else {
            header('Location: controllerProduct.php?action=create&message=' . $upload);
        }
    } else {
        $foto = $img == "" ? "users/sinfoto.jpg" : $img;
    }


    $action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];

    switch ($action) {
        case 'index':
            $cProduct->index();
            break;
        case 'admin':
            $cProduct->admin();
            break;
        case 'searchProduct':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $name = $_GET['nombre'];

                $cProduct->searchProduct($id, $name);
            } else {
                echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
            }
            break;
        case 'create':
            $cProduct->create();
            break;
        case 'saveCreate':
            $create = $cProduct->save('create', $name, $description, $price, $state, $foto);

            if ($create) {
                header('Location: controllerProduct.php?action=admin');
            } else {
                header('Location: controllerProduct.php?action=create&message=error');
            }
            break;
        case 'update':
            $prodId = $_GET['id'];
            $cProduct->update($prodId);
            break;
        case 'saveUpdate':
            $update = $cProduct->save('update', $name, $description, $price, $state, $foto, $prodId);

            if ($update) {
                header('Location: controllerProduct.php?action=admin');
            } else {
                header('Location: controllerProduct.php?action=update&id=' . $id . '&message=error');
            }
            break;
    }

} else {
    echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
}
