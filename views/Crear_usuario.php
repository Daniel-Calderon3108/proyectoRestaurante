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
    include("../Modelo/Cls_empleado.php");
    include("../Modelo/Cls_proveedor.php");
    include("../Modelo/ClsSelectores.php");
    $object = new Cls_usuario;
    $cliente = new Cls_cliente;
    $empleado = new Cls_empleado;
    $proveedor = new Cls_proveedor;
    $selector = new Cls_selectores;
    $selectorCargo = $selector->selectorCargo();
    $mensaje = "";
    $dato = $object->buscarUsuario($usuario);
    if (isset($_POST) && !empty($_POST) && $dato->rol_Nombre == "Cliente") {


        $nombre = $_POST['Nombre'];
        $apellido = $_POST['Apellido'];
        $correo = $_POST['Correo'];
        $direccion = $_POST['Direccion'];
        $tel = $_POST['Tel'];
        $usuario = $_POST['Usuario'];

        $resultado = $cliente->crear_cliente($nombre, $apellido, $correo, $direccion, $tel, $usuario);

        if ($resultado) {

            header('Location:Iniciar Sesion.php');
        } else {
            $mensaje = "Upps, algo fallo en la creacion";
        }
    } else  if (isset($_POST) && !empty($_POST) && $dato->rol_Nombre == "Empleado") {

        $nombre = $_POST['Nombre'];
        $apellido = $_POST['Apellido'];
        $documento = $_POST['Documento'];
        $estado = $_POST['Estado'];
        $tel = $_POST['Tel'];
        $cargo = $_POST['Cargo'];
        $usuario = $_POST['Usuario'];

        $resultado = $empleado->crear_empleado($nombre, $apellido, $documento, $estado, $tel, $cargo, $usuario);

        if ($resultado) {
            header('Location:Iniciar Sesion.php');
        } else {
            $mensaje = "Upps, algo fallo en la creacion";
        }
    } else if (isset($_POST) && !empty($_POST) && $dato->rol_Nombre == "Proveedor") {
        $nombre = $_POST['Nombre'];
        $correo = $_POST['Correo'];
        $tel = $_POST['Tel'];
        $documento = $_POST['Documento'];
        $estado = $_POST['Estado'];
        $link = $_POST['Link'];
        $usuario = $_POST['Usuario'];

        $resultado = $proveedor->crear_proveedor($nombre, $correo, $tel, $documento, $estado, $link, $usuario);

        if ($resultado) {
            header('Location:Iniciar Sesion.php');
        } else {
            $mensaje = "Upps, algo fallo en la creacion";
        }
    }

    ?>
</head>

<body>
    <div class="login">
        <form method="POST">
            <h2>Registrarse</h2>
            <input type="text" name="Nombre" placeholder="Nombre">
            <?php if ($dato->rol_Nombre == "Cliente") { ?>
                <input type="text" name="Apellido" placeholder="Apellido">
                <input type="text" name="Correo" placeholder="Correo Electronico">
                <input type="text" name="Direccion" placeholder="Direccion">
            <?php } else if ($dato->rol_Nombre == "Empleado") { ?>
                <input type="text" name="Apellido" placeholder="Apellido">
                <input type="text" name="Documento" placeholder="Documento">
                <input type="hidden" name="Estado" value="Activo">
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
                <input type="text" name="Correo" placeholder="Correo Electronico">
                <input type="text" name="Documento" placeholder="Documento">
                <input type="text" name="Link" placeholder="Link Pagina">
                <input type="hidden" name="Estado" value="Activo">
                </tr>
            <?php } ?>
            <input type="text" name="Tel" placeholder="Telefono">
            <input type="text" name="" placeholder="Usuario" value="<?php echo $dato->usua_Nombre; ?>" readonly="readonly">
            <input type="hidden" name="Usuario" placeholder="Usuario" value="<?php echo $dato->usua_Id; ?>">
            <input type="text" name="" placeholder="Rol" value="<?php echo $dato->rol_Nombre; ?>" readonly="readonly">
            <input type="submit" class="animated" value="Crear Usuario">
            <br><br>
        </form>

    </div>
</body>

</html>