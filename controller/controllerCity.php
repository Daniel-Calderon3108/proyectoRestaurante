<?php
require_once('../Model/modelCity.php');
require_once('../model/modelSelectors.php');

class ControllerCity extends modelCity
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
        require_once('../Views/city/index.php');
    }

    public function searchCity($id,$city,$country)
    {
        $data   = $this->searchCities($id,$city,$country);

        $this->resolve(false,'OK',$data);
    }

    public function create()
    {
        $selector = new ModelSelectors;
        $data = "";
        $listCountry = $selector->selectorPais("", $this->conexion);

        require_once('../views/city/formCity.php');
    }

    public function save($typeSave, $name, $country, $state, $cityId = "") 
    {
        if ($typeSave == "create") {
            $result = $this->createCity($name, $country, $state);
        } else if ($typeSave == "update") {
            $result = $this->updateCity($name, $country, $state, $cityId);
        } else {
            return false;
        }

        return $result;
    }

    public function update($cityId)
    {
        $result = $this->searchCityById($cityId);
        $data = $result->record;
        $listCountry = $result->country;
        $estado = $data->ciudEstado == 1 ? 'Activo' : 'Inactivo';
        require_once('../views/city/formCity.php');
    }
}

$cCity = new ControllerCity;

if (isset($_GET['action']) || isset($_POST['action'])) {
    $action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];

    $name = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $country = isset($_POST['pais']) ? $_POST['pais'] : "";
    $state = isset($_POST['estado']) ? $_POST['estado'] : "";
    $cityId = isset($_POST['ciud_Id']) ? $_POST['ciud_Id'] : "";

    switch ($action) {
        case 'index':
            $cCity->index();
            break;
        case 'searchCity':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $city = $_GET['city'];
                $country = $_GET['country'];
                $cCity->searchCity($id,$city,$country);
            } else {
                echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
            }
            break;
        case 'create':
            $cCity->create();
            break;
        case 'saveCreate':
            $create = $cCity->save('create', $name, $country, $state);

            if ($create) {
                header('Location: controllerCity.php?action=index');
            } else {
                header('Location: controllerCity.php?action=create&message=error');
            }
            break;
        case 'update':
            $cityId = $_GET['id'];
            $cCity->update($cityId);
            break;
        case 'saveUpdate':
            $update = $cCity->save('update', $name, $country, $state, $cityId);

            if ($update) {
                header('Location: controllerCity.php?action=index');
            } else {
                header('Location: controllerCity.php?action=update&id=' . $cityId . '&message=error');
            }
            break;
    }

} else {
    echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
}