<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location:../controller/controllerLogin.php?action=login');
} else {
    $SesionUsuario = $_SESSION['usuario'];
    $rol = $_SESSION['rol'];
    $foto = $_SESSION['foto'];
}

?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Views/img/icono.jpg" type="image/x-icon">
    <link rel="stylesheet" href="../Views/css/menu.css">
    <link rel="stylesheet" href="../Views/css/estilos.css">
    <link rel="stylesheet" href="../Views/css/footer.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->
    <script src="https://kit.fontawesome.com/853f775bbf.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <header>
        <nav class="menu">
            <section class="menu_container">
                <h1 class="menu_logo">DaCaAr System</h1>
                <ul class="menu_links">
                    <li class="menu_item">
                        <a href="../Views/Home.php" class="menu_link">Inicio</a>
                    </li>
                    <li class="menu_item menu_item--show">
                        <a href="#" class="menu_link"> <img src="../Views/img/<?= $foto == "" ? "sinfoto.jpg" : $foto ?>" class="img_item"><?= "| " . $SesionUsuario ?><img src="../Views/assets/arrow.svg" class="menu_arrow"></a>
                        <ul class="menu_nesting">
                            <li class="menu_inside">
                                <a href="#" class="menu_link menu_link--inside">Mi perfil</a>
                            </li>
                            <li class="menu_inside">
                                <a href="#" class="menu_link menu_link--inside">Editar Perfil</a>
                            </li>
                            <li class="menu_inside">
                                <a href="../controller/controllerLogin.php?action=login" class="menu_link menu_link--inside">Cerrar Sesión</a>
                            </li>
                        </ul>
                    </li>
                    <?php if ($rol == "Administrador") { ?>
                        <li class="menu_item">
                            <a href="../Controller/controllerEmployee.php?action=index" class="menu_link">Empleados</a>
                        </li>
                    <?php } ?>
                    <?php if ($rol == "Administrador" || $rol == "Empleado") { ?>
                        <li class="menu_item menu_item--show">
                            <a href="#" class="menu_link">Proveedores <img src="../Views/assets/arrow.svg" class="menu_arrow"></a>
                            <ul class="menu_nesting">
                                <li class="menu_inside">
                                    <a href="../Controller/controllerProvider.php?action=index" class="menu_link menu_link--inside">Proveedores</a>
                                </li>
                                <li class="menu_inside">
                                    <a href="../Controller/controllerBranch.php?action=index" class="menu_link menu_link--inside">Sedes</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if ($rol == "Administrador" || $rol == "Empleado") { ?>
                        <li class="menu_item">
                            <a href="../Controller/controllerCustomer.php?action=index" class="menu_link">Clientes</a>
                        </li>
                    <?php } ?>
                    <?php if ($rol != "Cliente") { ?>
                        <li class="menu_item">
                            <a href="../Controller/controllerInventory.php?action=index" class="menu_link">Inventario</a>
                        </li>
                    <?php } ?>
                    <?php if ($rol != "Proveedor") { ?>
                        <li class="menu_item">
                            <a href="../Controller/controllerProduct.php?action=index" class="menu_link">Productos</a>
                        </li>
                    <?php } ?>
                    <?php if ($rol == "Administrador") { ?>
                        <li class="menu_item menu_item--show">
                            <a href="#" class="menu_link">Paises - Ciudades <img src="../Views/assets/arrow.svg" class="menu_arrow"></a>
                            <ul class="menu_nesting">
                                <li class="menu_inside">
                                    <a href="../Controller/controllerCountry.php?action=index" class="menu_link menu_link--inside">Paises</a>
                                </li>
                                <li class="menu_inside">
                                    <a href="../Controller/controllerCity.php?action=index" class="menu_link menu_link--inside">Ciudades</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if ($rol != "Proveedor") { ?>
                        <li class="menu_item">
                            <a href="../controller/controllerOrder.php?action=index" class="menu_link">Pedidos</a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="menu_hamburguer">
                    <img src="../Views/assets/menu.svg" class="menu_img">
                </div>
            </section>
        </nav>
    </header>
</body>
<script src="../Views/js/menu.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> -->
</html>