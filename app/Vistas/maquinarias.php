<?php

session_start();
/*
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

*/
?>
<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Maquinas</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <link rel="stylesheet" href="../../assets/vendor/fonts/materialdesignicons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />
    <!-- Page CSS -->
    <!-- Añade esta línea en el encabezado del documento para incluir la librería de iconos Bootstrap -->
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="../../librerias/bootstrap-icon/icons/font/bootstrap-icons.min.css">

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <script src="../../assets/js/config.js"></script>
    <link rel="stylesheet" href="../../librerias/toastr/toastr.min.css">
    <script src="../../assets/vendor/libs/lottie/lottie.js"></script>
    <script src="../../assets/vendor/libs/lottie/lottie.min.js"></script>
</head>

<body>
    <?php
    include './Componentes/MenuSuperior.php';
    ?>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="layout-page">
                <div class="content-wrapper">
                    <div class="container-fluid d-flex flex-column ">
                        <div class="row">
                            <div class="col-md-12 mt-2 mb-2">
                                <div class="card">
                                    <form method="POST" id="form_maquinas" enctype="multipart/form-data">
                                        <div class="col-md-12">
                                            <div class="row align-items-center m-1">
                                                <div class="col">
                                                    <h2 class="title-table2 ms-2 text-primary">MAQUINAS DE <?php echo  strtoupper($_SESSION['empresa']) ?> </h2>
                                                </div>
                                                <div class="col">
                                                    <input class="form-control" type="text" placeholder="Buscar maquina" id="buscadorMaquinas" name="buscadorMaquinas">
                                                </div>
                                                <div class="col-12 col-md-3 text-end">
                                                    <button class="btn btn-success mx-3" onclick="modalAgregarMaquina();"> <i class="bi bi-plus-lg"> Agregar</i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>

                            <div class="row" id="contenedorCardsMaquinas">
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
li:hover  {
background-color: #A179FD !important;
color: white !important;
cursor: pointer;
}

    </style>

    <?php
    include './Modales/Maquinaria/modalAgregarMaquina.php';
    include './Modales/Maquinaria/modalEditarMaquina.php';
    include './Modales/Maquinaria/modalAsignarAlarma.php';
    ?>
    <!-- / Layout wrapper -->
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/js/menu.js"></script>
    <script src="../../assets/vendor/libs/sweetalert2/sweetalert2.all.min.js"></script>

    <!-- endbuild -->

    <script src="../../librerias/toastr/toastr.min.js"></script>
    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>


    <!-- JS Funciones-->
    <script src="../../assets/js/maquinaria.js" type="text/javascript"></script>



</body>

</html>