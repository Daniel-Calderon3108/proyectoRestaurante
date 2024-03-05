<?php
require_once('../Model/modelBranch.php');
require_once('../model/modelSelectors.php');

class ControllerBranch extends modelBranch
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
        require_once('../Views/branch/index.php');
    }

    public function searchBranch($id,$name)
    {
        $data   = $this->searchBranchs($id,$name);

        $this->resolve(false,'OK',$data);
    }

    public function create()
    {
        $selector = new ModelSelectors;
        $data = "";
        $listProveedor = $selector->selectorProveedor("", $this->conexion);
        $listCiudad = $selector->selectorCiudad("", $this->conexion);
        require_once('../views/branch/formBranch.php');
    }

    public function save($typeSave, $name, $provider, $city, $state, $id = "")
    {
        if ($typeSave == "create") {
            $result = $this->createBranch($name, $provider, $city, $state);
        } else if ($typeSave == "update") {
            $result = $this->updateBranch($name, $provider, $city, $id, $state);
        } else {
            return false;
        }

        return $result;
    }

    public function update($branchId)
    {
        $result = $this->searchBranchById($branchId);
        $data = $result->record;
        $listProveedor = $result->provider;
        $listCiudad = $result->city;
        $estado = $data->sedeEstado == 1 ? 'Activo' : 'Inactivo';
        require_once('../views/branch/formBranch.php');
    }
}

$cBranch = new ControllerBranch;

if (isset($_GET['action']) || isset($_POST['action'])) {
    $action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];

    $name = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $provider = isset($_POST['proveedor']) ? $_POST['proveedor'] : "";
    $city = isset($_POST['ciudad']) ? $_POST['ciudad'] : "";
    $state = isset($_POST['estado']) ? $_POST['estado'] : "";
    $id = isset($_POST['sede_Id']) ? $_POST['sede_Id'] : "";

    switch ($action) {
        case 'index':
            $cBranch->index();
            break;
        case 'searchBranch':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $name = $_GET['name'];
                $cBranch->searchBranch($id,$name);
            } else {
                echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
            }
            break;
        case 'create':
            $cBranch->create();
            break;
        case 'saveCreate':
            $create = $cBranch->save('create', $name, $provider, $city, $state);

            if ($create) {
                header('Location: controllerBranch.php?action=index');
            } else {
                header('Location: controllerBranch.php?action=create&message=error');
            }
            break;
        case 'update':
            $branchId = $_GET['id'];
            $cBranch->update($branchId);
            break;
        case 'saveUpdate':
            $update = $cBranch->save('update', $name, $provider, $city, $state, $id);
            
            if ($update) {
                header('Location: controllerBranch.php?action=index');
            } else {
                header('Location: controllerBranch.php?action=update&id=' . $id . '&message=error');
            }
            break;
    }

} else {
    echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
}
