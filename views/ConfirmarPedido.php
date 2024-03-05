<?php
if (isset($_GET['ped_FechaPedido'])) {
    $pedido = $_GET['ped_FechaPedido'];
} else {
    header("location:Pedido.php");
}
error_reporting(0);
?>
<!DOCTYPE html>

<head>
    <title>PIZZEON TOOL</title>
    <link rel="icon" type="image/css" href="Imagenes/hamburger-icon.png">
    <style>
        body {
            background-image: url("Imagenes/fondo2.png");
            text-align: center;
        }

        .cliente {
            text-decoration: none;
            color: rgb(133, 22, 22);
            font-size: 20px;
        }

        .cliente:hover {
            color: rgb(245, 11, 128)
        }

        .margin {
            margin-bottom: 15px;
        }

        h1 {
            color: #D10E0E;
            font-family: elephant;
            font-size: 70px;
            margin-bottom: 20px;
        }

        h2 {
            font-family: verdana;
            font-size: 20px;
        }

        .menu {
            border: solid 2px red;
            width: 40%;
            margin: auto;
            background: rgba(255, 246, 116, 0.925);
            border-radius: 10px;
        }

        .menu table {
            margin: auto;
        }

        input {
            border-radius: 5px;
            margin: 3px auto;
        }

        button {
            background: rgba(255, 246, 116, 0.925);
            border: solid 1px #F96105;
            padding: 10px 20px;
        }

        button:hover {
            color: #65605D;
            border: solid 1px #FC0905;
        }

        select {
            padding: 3px 40px;
            border-radius: 5px;
        }

        span {
            color: #ffff;
        }
    </style>
</head>

<body>
    <h1>Pizzeon<span>Tool</span></h1>
    <?php
    include("../Modelo/Cls_pedido.php");
    include("../Modelo/ClsSelectores.php");
    $object = new Cls_pedido;
    $selector = new Cls_selectores;
    $selectorSede = $selector->selectorSede();
    $mensaje = "";
    if (isset($_POST) && !empty($_POST)) {
        $total = $_POST['Total'];
        $llegada = $_POST['FechaLlegada'];
        $Id = $_POST['Id'];
        $sede = $_POST['Sede'];

        $resultado = $object->confirmarpedido($total,$llegada,$Id);

        if ($resultado) {
            header('Location:Pedido.php');
        } else {
            $mensaje = "Upps, algo fallo en la actualizacion";
        }
    }
    $datos = $object->BuscarPedidoCreado($pedido);
    $nombre = $datos->clie_Nombre;
    $apellido = $datos->clie_Apellido;
    $nombreCompleto = $nombre." ".$apellido;
    $cantidad = intval($datos->ped_Cantidad);
    $precio = intval($datos->prod_Precio);
    $total = $cantidad * $precio;

    ?>
    <div class="menu">
        <h2>A continuación, Sr(a) <?php echo $nombreCompleto; ?>. Mostramos detalle del pedido</h2>
        <form method="post">
            <table>
                <tr>
                    <td>Producto</td>
                    <td><input type="text" name="Producto" value="<?php echo $datos->prod_Nombre; ?>" readonly="readonly"></td>
                    <td><input type="hidden" name="Id" value="<?php echo $datos->ped_Id; ?>"></td>
                </tr>
                <tr>
                    <td>Cantidad</td>
                    <td><input type="text" name="Cantidad" value="<?php echo $cantidad; ?>" readonly="readonly"></td>
                </tr>
                <tr>
                    <td>Precio C/U</td>
                    <td><input type="text" name="Cantidad" value="<?php echo $precio; ?>" readonly="readonly"></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><input type="text" name="Total" value="<?php echo $total; ?>" readonly="readonly"></td>
                </tr>
                <tr>
                    <td>Fecha Pedido</td>
                    <td><input type="date" name="FechaPedido" value="<?php echo $pedido; ?>" readonly="readonly"></td>
                </tr>
                <tr>
                    <td>Fecha Llegada</td>
                    <td><input type="date" name="FechaLlegada" value="<?php echo $pedido; ?>" readonly="readonly"></td>
                </tr>
            </table><br>
            <button>Confirmar Pedido</button>
        </form><br>
        <h3><?php echo $mensaje ?></h3>
    </div>
</body>

</html>