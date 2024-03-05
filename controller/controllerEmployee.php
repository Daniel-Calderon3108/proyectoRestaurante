<?php
require_once('../model/modelEmployee.php');
require_once('../model/modelSelectors.php');
require_once('../model/uploadImg.php');

class ControllerEmployee extends modelEmployee
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
        require_once('../views/employee/index.php');
    }

    public function searchEmployee($id, $name, $lastName)
    {
        $data = $this->searchEmployees($id, $name, $lastName);

        $this->resolve(false, 'OK', $data);
    }

    public function create()
    {
        $selector = new ModelSelectors;
        $data = "";
        $listCargo = $selector->selectorCargo("", $this->conexion);
        $listTipoDocumento = $selector->selectorTipoDocumento("", $this->conexion);
        require_once('../views/employee/formEmployee.php');
    }

    public function save($typeSave, $name, $lastName, $type, $document, $tel, $position, $user, $pass, $img, $state, $usua_id = "", $id = "")
    {

        if ($typeSave == "create") {
            $result = $this->createEmployee($name, $lastName, $type, $document, $tel, $position, $user, $pass, $img, $state);
        } else if ($typeSave == "update") {
            $result = $this->updateEmployee($name, $lastName, $document, $tel, $position, $id, $user, $pass, $usua_id, $type, $img, $state);
        } else {
            return false;
        }
        return $result;
    }

    public function update($employeeId)
    {
        $result = $this->searchEmployeeById($employeeId);
        $data = $result->record;
        $listCargo = $result->position;
        $listTipoDocumento = $result->typeDocument;
        $estado = $data->UsEstado == 1 ? "Activo" : "Inactivo";
        require_once('../views/employee/formEmployee.php');
    }
}

$cEmployee = new ControllerEmployee;
$uploadImg = new UploadImg;


if (isset($_GET['action']) || isset($_POST['action'])) {
    $action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];

    $name = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $lastName = isset($_POST['apellido']) ? $_POST['apellido'] : "";
    $type = isset($_POST['tipo_documento']) ? $_POST['tipo_documento'] : "";
    $document = isset($_POST['documento']) ? $_POST['documento'] : "";
    $tel = isset($_POST['tel']) ? $_POST['tel'] : "";
    $position = isset($_POST['cargo']) ? $_POST['cargo'] : "";
    $user = isset($_POST['usuario']) ? $_POST['usuario'] : "";
    $pass = isset($_POST['clave']) ? $_POST['clave'] : "";
    $estado = isset($_POST['estado']) ? $_POST['estado'] : "";
    $file = isset($_FILES['fotoUsuario']['name']) ? $_FILES['fotoUsuario']['name'] : "";
    $usua_id = isset($_POST['usua_Id']) ? $_POST['usua_Id'] : "";
    $id = isset($_POST['empl_Id']) ? $_POST['empl_Id'] : "";
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
            header('Location: controllerEmployee.php?action=create&message=' . $upload);
        }
    } else {
        $foto = $img == "" ? "users/sinfoto.jpg" : $img;
    }

    switch ($action) {
        case 'index':
            $cEmployee->index();
            break;
        case 'searchEmployee':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $name = $_GET['name'];
                $lastName = $_GET['lastName'];
                $cEmployee->searchEmployee($id, $name, $lastName);
            } else {
                echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
            }
            break;
        case 'create':
            $cEmployee->create();
            break;
        case 'saveCreate':
            $create = $cEmployee->save("create", $name, $lastName, $type, $document, $tel, $position, $user, $pass, $foto, $estado);

            if ($create) {
                header('Location: controllerEmployee.php?action=index');
            } else {
                header('Location: controllerEmployee.php?action=create&message=error');
            }
            break;
        case 'update':
            $employeeId = $_GET['id'];
            $cEmployee->update($employeeId);
            break;
        case 'saveUpdate':
            $update = $cEmployee->save('update', $name, $lastName, $type, $document, $tel, $position, $user, $pass, $foto, $estado, $usua_id, $id);

            if ($update) {
                header('Location: controllerEmployee.php?action=index');
            } else {
                header('Location: controllerEmployee.php?action=update&id=' . $id . '&message=error');
            }
            break;
        default:
            $cEmployee->index();
            break;
    }
} else {
    echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
}
