<?php
if (isset($_GET['usua_Nombre'])) {
    $usuario = strval($_GET['usua_Nombre']);
} else {
    header("location:Registrarse.php");
}
?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>PIZZEON TOOL</title>
    <link rel="icon" type="image/css" href="Imagenes/hamburger-icon.png">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/login.css">
    <?php
    include("../Modelo/Cls_usuario.php");
    include("../Modelo/Cls_cliente.php");
    include("../Modelo/Cls_proveedor.php");
    include("../Modelo/ClsSelectores.php");
    $object = new Cls_usuario;
    $proveedor = new Cls_proveedor;
    $selector = new Cls_selectores;
    $selectorCargo = $selector->selectorCargo();
    $mensaje = "";
    $BuscarEmpleado = $object->buscar_usuarioempleadoespecifico($usuario);
    $BuscarCliente = $object->buscar_usuarioclienteespecifico($usuario);
    $BuscarProveedor = $object->buscar_usuarioproveedorespecifico($usuario);
    $dato = $object->buscarUsuario($usuario);
    if (isset($_POST) && !empty($_POST) && $dato->rol_Nombre == "Cliente") {


        $nombre = $_POST['Nombre'];
        $apellido = $_POST['Apellido'];
        $correo = $_POST['Correo'];
        $direccion = $_POST['Direccion'];
        $tel = $_POST['Tel'];
        $usuario = $_POST['Usuario'];

        $resultado = $object->actualizar_clienteusuario($nombre, $apellido, $correo, $direccion, $tel, $usuario);

        if ($resultado) {

            header('Location:Home.php');
        } else {
            $mensaje = "Upps, algo fallo en la creacion";
        }
    } else  if (isset($_POST) && !empty($_POST) && $dato->rol_Nombre == "Empleado") {

        $nombre = $_POST['Nombre'];
        $apellido = $_POST['Apellido'];
        $documento = $_POST['Documento'];
        $tel = $_POST['Tel'];
        $cargo = $_POST['Cargo'];
        $usuarioNombre = $_POST['Usuario'];

        $resultado = $object->actualizar_empleadousuario($nombre, $apellido, $documento, $tel, $cargo, $usuarioNombre);

        if ($resultado) {
            header('Location:Home.php');
        } else {
            $mensaje = "Upps, algo fallo en la creacion";
        }
    } else if (isset($_POST) && !empty($_POST) && $dato->rol_Nombre == "Proveedor") {
        $nombre = $_POST['Nombre'];
        $correo = $_POST['Correo'];
        $tel = $_POST['Tel'];
        $documento = $_POST['Documento'];
        $link = $_POST['Link'];
        $usuario = $_POST['Usuario'];

        $resultado = $object->actualizar_proveedorusuario($nombre, $correo, $tel, $documento, $link, $usuario);

        if ($resultado) {
            header('Location:Home.php');
        } else {
            $mensaje = "Upps, algo fallo en la creacion";
        }
    }

    ?>
</head>

<body>
    <div class="login">
        <form method="POST">
            <h2>Actualizar Usuario</h2>
            <a href="Home.php">Regresar</a>
            <?php if ($dato->rol_Nombre == "Cliente") { ?>
                <input type="text" name="Nombre" placeholder="Nombre" value="<?php echo $BuscarCliente->clie_Nombre; ?>">
                <input type="text" name="Apellido" placeholder="Apellido" value="<?php echo $BuscarCliente->clie_Apellido; ?>">
                <input type="text" name="Correo" placeholder="Correo Electronico" value="<?php echo $BuscarCliente->clie_Correo; ?>">
                <input type="text" name="Direccion" placeholder="Direccion" value="<?php echo $BuscarCliente->clie_Direccion; ?>">
                <input type="text" name="Tel" placeholder="Telefono" value="<?php echo $BuscarCliente->clie_Celular; ?>">
            <?php } else if ($dato->rol_Nombre == "Empleado") { ?>
                <input type="text" name="Nombre" placeholder="Nombre" value="<?php echo $BuscarEmpleado->empl_Nombre; ?>">
                <input type="text" name="Apellido" placeholder="Apellido" value="<?php echo $BuscarEmpleado->empl_Apellido; ?>">
                <input type="text" name="Documento" placeholder="Documento" value="<?php echo $BuscarEmpleado->empl_Documento; ?>">
                <input type="text" name="Tel" placeholder="Telefono" value="<?php echo $BuscarEmpleado->empl_Telefono; ?>">
                <select name="Cargo" id="">
                    <option value="0">Seleccione Cargo</option>
                    <?php while ($row = mysqli_fetch_object($selectorCargo)) {
                        $idCargo = $row->carg_Id;
                        $cargo = $row->carg_Nombre;
                    ?>
                        <option value="<?php echo $idCargo; ?>"><?php echo $cargo; ?></option>
                    <?php } ?>
                </select>
            <?php } else if ($dato->rol_Nombre == "Proveedor") { ?>
                <input type="text" name="Nombre" placeholder="Nombre" value="<?php echo $BuscarProveedor->prov_Nombre; ?>">
                <input type="text" name="Correo" placeholder="Correo Electronico" value="<?php echo $BuscarProveedor->prov_Correo; ?>">
                <input type="text" name="Documento" placeholder="Documento" value="<?php echo $BuscarProveedor->prov_Documento; ?>">
                <input type="text" name="Link" placeholder="Link Pagina" value="<?php echo $BuscarProveedor->prov_Link_Pagina; ?>">
                <input type="text" name="Tel" placeholder="Telefono" value="<?php echo $BuscarProveedor->prov_Telefono; ?>">
                </tr>
            <?php } ?>
            <input type="text" name="Usuario" placeholder="Usuario" value="<?php echo $dato->usua_Nombre; ?>" readonly="readonly">
            <input type="submit" class="animated" value="Actualizar Usuario">
            <br><br>
        </form>

    </div>
</body>

</html>