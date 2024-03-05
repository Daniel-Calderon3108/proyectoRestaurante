<?php
session_start();
require_once('../Model/modelLogin.php');
if (isset($_SESSION['usuario'])) {
    unset($_SESSION['usuario']);
    unset($_SESSION['id']);
    unset($_SESSION['rol']);
    unset($_SESSION['foto']);
    header("Location:../controller/controllerLogin.php?action=login");
}

class ControllerLogin
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

    public function login()
    {
        require_once('../Views/login.php');
    }

    public function validateLogin($user,$password)
    {
        $model = new ModelLogin;
        $login = $model->validateLogin($user,$password);

        if ($login != false) {
            $_SESSION['id'] = session_create_id();
            $_SESSION['usuario'] = $login['usua_Nombre'];
            $_SESSION['rol'] = $login['rol_Nombre'];
            $_SESSION['foto'] = $login['usua_foto'];


            $data = (object) [
                'url' => '../Views/Home.php'
            ];

            $this->resolve(false,'OK',$data);
        } else {
            $this->resolve(true,'Usuario o Contraseña Incorrectos.');
        }
    }
}

$login = new ControllerLogin;

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'login':
            $login->login();
            break;
        case 'validateLogin':
            if (isset($_GET['user'])) {
                $user      = $_GET['user'];
                $password  = $_GET['password'];
                $login->validateLogin($user,$password);
            } else {
                echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
            }
            break;
    }
} else {
    echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
}