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
            font-size: 35px;
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

        select {
            padding: 3px 40px;
            border-radius: 5px;
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

        span {
            color: #ffff;
        }
    </style>
</head>

<body>

    <h1>Pizzeon<span>Tool</span></h1>
    <div class="margin"><a class="cliente" href="Pedido.php">Regresar</a></div>
    <?php
    include("../Modelo/Cls_pedido.php");
    include("../Modelo/ClsSelectores.php");
    $object = new Cls_pedido;
    $selector = new Cls_selectores;
    $selectorCliente = $selector->selectorCliente();
    $selectorProducto = $selector->selectorProducto();
    $mensaje = "";

    if (isset($_POST) && !empty($_POST) && $_POST['Producto'] != 0 && $_POST['Cliente'] != 0) {
        $cantidad = $_POST['Cantidad'];
        $fechaPedido = $_POST['FechaPedido'];
        $cliente = $_POST['Cliente'];
        $producto = $_POST['Producto'];


        $resultado = $object->crear_pedido($cantidad, $fechaPedido, $cliente, $producto);

        if ($resultado) {
            header('Location:ConfirmarPedido.php?ped_FechaPedido='.$fechaPedido);
        } else {
            $mensaje = "Upps, algo fallo en la creacion";
        }
    }
    ?>
    <div class="menu">
        <h2>Crear Pedido</h2>
        <form method="post">
            <table>
                <tr>
                    <td>Cantidad</td>
                    <td><input type="number" name="Cantidad"></td>
                </tr>
                <tr>
                    <td>Fecha Pedido</td>
                    <td><input type="date" name="FechaPedido"></td>
                </tr>
                    <td>Cliente</td>
                    <td><select name="Cliente" id="">
                            <option value="0">No se ha seleccionado</option>
                            <?php while ($row = mysqli_fetch_object($selectorCliente)) {
                                $idCliente = $row->clie_Id;
                                $name = $row->clie_Nombre;
                                $lastName = $row->clie_Apellido;

                            ?>
                                <option value="<?php echo $idCliente ?>"><?php echo $name." ".$lastName; ?></option>
                            <?php } ?>
                        </select></td>
                </tr>
                <tr>
                    <td>Producto</td>
                    <td><select name="Producto" id="" style="width: 250px;">
                            <option value="0">No se ha seleccionado</option>
                            <?php while ($row = mysqli_fetch_object($selectorProducto)) {
                                $idProducto = $row->prod_Id;
                                $productoNombre = $row->prod_Nombre;
                                $productoPrecio = $row->prod_Precio;

                            ?>
                                <option value="<?php echo $idProducto ?>"><?php echo $productoNombre.", Precio $".$productoPrecio; ?></option>
                            <?php } ?>
                        </select></td>
                </tr>
            </table><br>
            <button>Siguiente</button>
        </form><br>
        <h3><?php echo $mensaje ?></h3>
    </div>

</body>

</html>