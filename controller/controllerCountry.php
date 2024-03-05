<?php
require_once('../Model/modelCountry.php');
require_once('../model/uploadImg.php');

class ControllerCountry extends modelCountry
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
        require_once('../Views/country/index.php');
    }

    public function searchCountry($id, $name)
    {
        $data   = $this->searchCountries($id, $name);

        $this->resolve(false, 'OK', $data);
    }

    public function create()
    {
        $data = "";
        require_once('../views/country/formCountry.php');
    }

    public function save($saveType, $name, $flag, $state,$city, $stateCity, $countryId = '')
    {
        if ($saveType == 'create') {
            $result = $this->createCountry($name, $flag, $state, $city, $stateCity);
        } else if ($saveType == 'update') {
            $result = $this->updateCountry($name, $flag, $state, $countryId);
        } else {
            return false;
        }

        return $result;
    }

    public function update($countryId)
    {
        $data = $this->searchCountryById($countryId);
        $estado = $data->paisEstado == 1 ? 'Activo' : 'Inactivo';
        require_once('../views/country/formCountry.php');
    }
}

$cCountry = new ControllerCountry;
$uploadImg = new UploadImg;

if (isset($_GET['action']) || isset($_POST['action'])) {
    $action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];

    $name = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $flag = isset($_FILES['bandera']['name']) ? $_FILES['bandera']['name'] : ""; 
    $state = isset($_POST['estado']) ? $_POST['estado'] : "";
    $city = isset($_POST['ciudad']) ? $_POST['ciudad'] : "";
    $stateCity = isset($_POST['estadoCiudad']) ? $_POST['estadoCiudad'] : "";
    $countryId = isset($_POST['pais_Id']) ? $_POST['pais_Id'] : "";
    $img = isset($_POST['imgBandera']) ? $_POST['imgBandera'] : "";
    $foto = "";

    if (isset($flag) && $flag != "") {

        $extension = $_FILES['bandera']['type'];
        $size = $_FILES['bandera']['size'];
        $temp = $_FILES['bandera']['tmp_name'];

        $upload = $uploadImg->upload($flag, $extension, $size, $temp, 'flags');

        if ($upload) {
            $foto = "flags/" . $flag;
        } else {
            header('Location: controllerEmployee.php?action=create&message=' . $upload);
        }
    } else {
        $foto = $img == "" ? "users/sinfoto.jpg" : $img;
    }

    switch ($action) {
        case 'index':
            $cCountry->index();
            break;
        case 'searchCountry':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $name = $_GET['name'];
                $cCountry->searchCountry($id, $name);
            } else {
                echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
            }
            break;
        case 'create':
            $cCountry->create();
            break;
        case 'saveCreate':
            $create = $cCountry->save('create', $name, $foto, $state, $city, $stateCity);

            if ($create) {
                header('Location: controllerCountry.php?action=index');
            } else {
                header('Location: controllerCountry.php?action=create&message=error');
            }
            break;
        case 'update':
            $countryId = $_GET['id'];
            $cCountry->update($countryId);
            break;
        case 'saveUpdate':
            $update = $cCountry->save('update', $name, $foto, $state, $city, $stateCity, $countryId);

            if ($update) {
                header('Location: controllerCountry.php?action=index');
            } else {
                header('Location: controllerCountry.php?action=update&id=' . $countryId . '&message=error');
            }
            break;
    }
} else {
    echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
}
