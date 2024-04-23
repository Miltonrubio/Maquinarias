<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>APIS MAQUINAS</title>

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

  <link rel="stylesheet" href="../../assets/css/maquinaria.css">

  <script src="../../assets/vendor/libs/lottie/lottie.js"></script>
  <script src="../../assets/vendor/libs/lottie/lottie.min.js"></script>
</head>

<style>
  .form {
    display: inline-block;
  }

  code {
    font-family: 'Roboto', sans-serif;
    font-size: 15px;
    font-weight: bold;
    padding: 10px;

  }

  .form button {
    margin-top: 1em;
  }

  .form label {
    font-size: 15px;
    font-family: 'Roboto', sans-serif;
    margin: 0;
    font-weight: bold;
    padding: 0;
  }

  .titulo {
    font-size: 2em;
    font-family: 'Roboto', sans-serif;
    font-weight: bold;
    ;
    margin: 0;
    padding: 0;
    margin-bottom: 1em;

  }

  .contenedor-inputs {
    margin-top: -1.4em;
  }

  .padre {
    margin-top: 10px;
  }

  .section {
    width: 65%;
    border: 1px solid gray;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 7px;
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2);
  }

  .separator {
    display: flex;
    width: 100%;
    height: auto;
    background-color: aquamarine;
    align-items: center;
    justify-content: center;
  }
</style>


<body>
  <div class="container mt-4">
    <h1 class="titulo">Apis Maquinas Version Movil </h1>

    <!--
    <div class="section">
      <form class="form" enctype="multipart/form-data" action="../Controllers/Apiback.php" method="POST">
        <div><label>Login</label></div>
        <input type="hidden" name="opcion" value="1">
        <code>
          <br />
          method = "POST"<br />
          name="opcion" value="1"<br />
          name="telefono" value ="2381323648"<br />
          name="password" value = "123456"
        </code><br>
        <div class="form-floating contenedor-inputs padre">
          <input type="hidden" name="opcion" value="1"><br>
          <input type="number" name="telefono" value="2381323648"><br>
          <label for="floatingInput">Telefono</label>

        </div>
        <div class="form-floating contenedor-inputs padre"><br>
          <input type="text" name="password" value="123456">
          <label for="floatingInput">password</label>
        </div>
        <button type="submit" class="btn btn-primary">consultar</button>
      </form>
    </div>
 -->
    <div class="section">
      <form class="form" enctype="multipart/form-data" action="../Controlador/ApisMovil.php" method="POST">
        <div><label>Consultar Servicios Activos</label></div>
        <input type="hidden" name="opcion" value="1">
        <code>
          <br />
          method = "POST"<br />
          name="opcion" value="1"<br />
        </code><br>
        <button type="submit" class="btn btn-primary">consultar</button>
      </form>
    </div>

    <div class="section">
      <form class="form" enctype="multipart/form-data" action="../Controlador/ApisMovil.php" method="POST">
        <div><label>Login</label></div>
        <input type="hidden" name="opcion" value="2">
        <code>
          <br />
          method = "POST"<br />
          name="opcion" value="2"<br />
          name="telefono" value="2382115594"<br />
          name="password" value="1234"<br />
        </code><br>

        <div class="form-floating contenedor-inputs padre">
          
          <input type="number" name="telefono" value="2382115594"><br>

        </div>
        <div class="form-floating contenedor-inputs padre"><br>
          <input type="text" name="password" value="1234">
        </div>

        <button type="submit" class="btn btn-primary">consultar</button>
      </form>
    </div>




    <div class="section">
      <form class="form" enctype="multipart/form-data" action="../Controlador/ApisMovil.php" method="POST">
        <div><label>Login</label></div>
        <input type="hidden" name="opcion" value="3">
        <code>
          <br />
          method = "POST"<br />
          name="opcion" value="3"<br />
          name="ID_maquina" value="3"<br />
        </code><br>

        <div class="form-floating contenedor-inputs padre">
        ID_maquina:
          <input type="number" name="ID_maquina" value="3"><br>
        </div>

        <button type="submit" class="btn btn-primary">consultar</button>
      </form>
    </div>

