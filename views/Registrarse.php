<?php

session_start();
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
    include("../Modelo/ClsSelectores.php");
    $object = new Cls_usuario;
    $selector = new Cls_selectores;
    $selectorRol = $selector->selectorRol();
    $mensaje = "";

    if (isset($_POST) && !empty($_POST)) {

        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
        $rol = $_POST['Rol'];
        $registro = $object->crear_usuario($usuario, $clave, $rol);

        if ($registro) {

            header("location:Crear_usuario.php?usua_Nombre=" . $usuario);
        } else {
            echo "Upps, algo fallo en la creacion";
        }
    }
    ?>
</head>

<body>
    <div class="login">
        <form method="POST">
            <h2>Registrarse</h2>
            <input name="usuario" placeholder="Usuario" type="text" required maxlength="16" />
            <input name="clave" placeholder="contraseña" type="password" required maxlength="18" />
            <select name="Rol" id="" required>
                <option value="0">Seleccionar Rol</option>
                <?php while ($row = mysqli_fetch_object($selectorRol)) {
                    $idRol = $row->rol_Id;
                    $rol = $row->rol_Nombre;
                ?>
                    <option value="<?php echo $idRol; ?>"><?php echo $rol; ?></option>
                <?php } ?>
            </select>
            <input type="submit" class="animated" value="Registrarse">
            <a class="create" href='Iniciar Sesion.php'>¿Ya tienes cuenta? Inicia Sesión</a>
        </form>
    </div>
</body>

</html>