<?php
session_start();
require "../Modelo/Checks.php";

$bd = new Checks();

switch ($_REQUEST["operador"]) {
    case 'obtener_plantillas_checks':
        # code
        break;

    default:
        $response = array(
            'response' => 'error',
            'message' => 'Opción no valida'
        );
        break;
}
