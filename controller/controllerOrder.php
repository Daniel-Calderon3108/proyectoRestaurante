<?php
require_once('../Model/modelOrder.php');
class ControllerOrder
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
        $fecha = date('Y-m-d');
        require_once('../Views/order/index.php');
    }

    public function searchOrder($id,$customerName,$customerLastName,$date)
    {
        $model  = new modelOrder;
        $data   = $model->searchOrder($id,$customerName,$customerLastName,$date);

        $this->resolve(false,'OK',$data);
    }
}

$cOrder = new ControllerOrder;

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'index':
            $cOrder->index();
            break;
        case 'searchOrder':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $customerName = $_GET['customerName'];
                $customerLastName = $_GET['customerLastName'];
                $date = $_GET['fecha'];
                $cOrder->searchOrder($id,$customerName,$customerLastName,$date);
            } else {
                echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
            }
            break;
    }

} else {
    echo 'Página no encontrada, asegurese que la url este bien escrita e intente de nuevo';
}