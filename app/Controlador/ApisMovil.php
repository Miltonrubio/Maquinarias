<?php
require_once '../Modelo/Maquinas.php';



if (!empty($_POST['opcion'])) {
  $opcion = $_POST['opcion'];
  $control = new Maquinas();
  switch ($opcion) {
    case 1:

      $dato =  $control->obtenerMaquinas();

      if ($dato) {
        if (count($dato) > 0) {
          $response = json_encode($dato);
        } else {
          $response = 'no-data';
        }
      } else {
        $response = 'error';
      }
      echo $response;


      break;


    case 2:

      $telefono = $_POST['telefono'];
      $password = $_POST['password'];

      $datos = $control->Consultarusurio($telefono, $password);

      if ($datos === "No hay datos") {
        $response = 'Debe estar mal algo';
      } elseif (empty($datos)) {
        $response = 'No coinciden los datos';
      } else {
        $response = json_encode($datos);
      }

      echo $response;

      break;



    case 3:

      $ID_maquina = $_POST['ID_maquina'];

      $datos = $control->EliminarMaquina($ID_maquina);

      if ($datos) {
        $response = 'Exitoso';
      } else {
        $response = 'fallo';
      }

      echo $response;

      break;



      /*
    case 2:
      $dato =  $control->ConsultarServiciosActivos();
      break;
    case 3:
      $idventa = $_POST['idventa'];
      $dato =  $control->ConsultarRefaccion($idventa);
      break;
      */
    default:

      break;
  }
} else {

  echo "No se agrego la opcion";
}
