<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['ID_usuario'])) {
    // Redirigir a la página de inicio de sesión
    header('Location: ./login.php');
    exit();
}
// Verificar si el usuario tiene el permiso adecuado
if ($_SESSION['tipo'] !== 'SUPERADMIN') {
    // Redirigir o mostrar un mensaje de error
    header('Location: ./error.html');
    exit();
}
?>
<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Plantillas Checks</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <!-- Importacion de los estilos -->
    <?php include './Componentes/ccs.php' ?>
</head>

<body>
    <?php
    include './Componentes/MenuSuperior.php';
    ?>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="layout-page">
                <div class="content-wrapper">
                    <div class="container-fluid d-flex flex-column vh-100">
                        <div class="row">
                            <div class="col-md-12 mt-md-5 mt-lg-4 pt-md-2 pt-lg-0">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="mb-3 bg-light col-md-12">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <h1 class="title-table2 ms-2 text-primary">Administrar plantillas</h1>
                                                </div>
                                                <div class="col-3">
                                                </div>
                                                <div class="col-3">
                                                </div>
                                                <div class="col-3">
                                                    <button class="btn btn-success mx-3" onclick="modalAgregarPlantilla();"> <i class="bi bi-person-fill-add" > Agregar</i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="overflow-auto">
                                            <table class="table color-de-texto">
                                                <thead class="table-light">
                                                    <tr class="text-center">
                                                        <th>Nombre</th>
                                                        <th>Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bodyTableUsuarios" class="text-center">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Importacion de los modales -->
    <?php
    include './Modales/PlantillasChecks/ModalAgregarPlantilla.php';
    ?>
    
    <!-- Importacion de js -->
    <?php include './Componentes/js.php' ?>

    <!-- JS Funciones-->
    <script src="../../assets/js/Plantillas.js" type="text/javascript"></script>



</body>

</html>