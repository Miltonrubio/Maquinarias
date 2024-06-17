<?php
session_start();
require "../Modelo/Checks.php";

$bd = new Checks();

switch ($_REQUEST["operador"]) {
    case 'obtener_plantillas_checks':
        try {
            $plantillas = $bd->obtenerPlantillas();
            if (!empty($plantillas)) {
                $response = array(
                    'response' => 'success',
                    'data' => $plantillas
                );
            } else {
                $response = array(
                    'response' => 'no-data'
                );
            }
        } catch (\Throwable $th) {
            $response = array(
                'response' => 'error',
                'message' => $th->getMessage(),
            );
        }
        echo json_encode($response);
        break;

    case 'registrar_plantilla':
        $nombrePlantilla = isset($_POST['nombre_plantilla']) ? $_POST['nombre_plantilla'] : '';
        $fotoPlantilla = isset($_FILES['img_default']) ? $_FILES['img_default'] : '';

        if (!empty($nombrePlantilla) && !empty($fotoPlantilla['name'])) {
            try {
                $nombreImagen = $bd->subirFotoMaquina($fotoPlantilla);
                $bd->registrarPlantilla($nombrePlantilla, $nombreImagen);
                $response = array(
                    'response' => 'success'
                );
            } catch (\Throwable $th) {
                $response = array(
                    'response' => 'error',
                    'message' => $th->getMessage(),
                );
            }
        } else{
            $response = array(
                'response' => 'required'
            );
        }
        echo json_encode($response);
        break;

    case 'obtener_checks_plantilla':
        $idPlantilla = isset($_POST['idPlantilla']) ? $_POST['idPlantilla'] : '';
        if (!empty($idPlantilla)) {
            try {
                $checks = $bd->obtenerChecksPlantilla($idPlantilla);
                if (!empty($checks)) {
                    $response = array(
                        'response' => 'success',
                        'data' => $checks
                    );
                } else {
                    $response = array(
                        'response' => 'no-data'
                    );
                }
            } catch (\Throwable $th) {
                $response = array(
                    'response' => 'error',
                    'message' => $th->getMessage(),
                );
            }
        } else {
            $response = array(
                'response' => 'required'
            );
        }
        echo json_encode($response);
        break;

    default:
        $response = array(
            'response' => 'error',
            'message' => 'Opción no valida'
        );
        break;
}
