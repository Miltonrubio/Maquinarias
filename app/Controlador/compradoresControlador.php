<?php
session_start();
require "../Modelo/Compradores.php";

$empresaSesion =  $_SESSION['empresa'];
$ID_sesionIniciada = $_SESSION['ID_usuario'];

$bd = new Admin();;

switch ($_REQUEST["operador"]) {
    case 'obtener_solicitudes':
        $usuarios = $bd->obtenerSolcilitudesPorTipoUsuario($empresaSesion);
        if ($usuarios !== false) {
            if (count($usuarios) > 0) {
                $response = json_encode($usuarios);
            } else {
                $response = 'no-data';
            }
        } else {
            $response = 'error';
        }
        echo $response;
        break;



    case 'obtener_tarjetas':
        $tarjetas = $bd->obtenerTarjetas($empresaSesion);
        if ($tarjetas !== false) {
            if (count($tarjetas) > 0) {
                $response = json_encode($tarjetas);
            } else {
                $response = 'no-data';
            }
        } else {
            $response = 'error';
        }
        echo $response;

        break;



    case 'obtener_anomalias':
        if (isset($_POST['ID_solicitud'])) {
            $ID_solicitud = $_POST['ID_solicitud'];
            // Aquí puedes usar $ID_anomalia en tu modelo para obtener las anomalías específicas
        } else {
            // Si no se proporcionó ID_anomalia, puedes manejar este caso como lo hacías antes
            $ID_solicitud = ''; // O algún valor predeterminado que tenga sentido para tu lógica
        }
        $anomalias = $bd->obtenerAnomalias($ID_solicitud);
        if ($anomalias !== false) {
            if (count($anomalias) > 0) {
                $response = json_encode($anomalias);
            } else {
                $response = 'no-data';
            }
        } else {
            $response = 'error';
        }
        echo $response;

        break;



    case 'obtener_evidencias':
        if (isset($_POST['ID_solicitud'])) {
            $ID_solicitud = $_POST['ID_solicitud'];
            // Aquí puedes usar $ID_anomalia en tu modelo para obtener las anomalías específicas
        } else {
            // Si no se proporcionó ID_anomalia, puedes manejar este caso como lo hacías antes
            $ID_solicitud = ''; // O algún valor predeterminado que tenga sentido para tu lógica
        }

        $evidencias = $bd->obtenerEvidencias($ID_solicitud);
        if ($evidencias !== false) {
            if (count($evidencias) > 0) {
                $response = json_encode($evidencias);
            } else {
                $response = 'no-data';
            }
        } else {
            $response = 'error';
        }
        echo $response;
        break;



    case 'agendar_pedido':

        $fecha_hora_actual = date("Y-m-d H:i:s");
        $fechaAgendada = isset($_POST['fechaAgendada']) ? $_POST['fechaAgendada'] : '';
        $horaAgendada = isset($_POST['horaAgendada']) ? $_POST['horaAgendada'] : '';
        $proovedorAgendado = isset($_POST['proovedorAgendado']) ? $_POST['proovedorAgendado'] : '';
        $textObservaciones = isset($_POST['textObservaciones']) ? $_POST['textObservaciones'] : '';
        $solicitante = isset($_POST['solicitante']) ? $_POST['solicitante'] : '';
        
        if (!empty($proovedorAgendado) && !empty($solicitante) && !empty($horaAgendada) && !empty($fechaAgendada)) {

            // Validar si la fecha agendada es mayor o igual a la fecha actual
            if (strtotime($fechaAgendada) > strtotime($fecha_hora_actual)) {
                // Si la fecha agendada es igual a la fecha actual, se debe validar la hora
                if (strtotime($fechaAgendada) == strtotime($fecha_hora_actual) && strtotime($horaAgendada) <= strtotime(date("H:i:s"))) {
                    $response = 'horamenor';
                } else {
                    if ($bd->agregarSolicitud($fecha_hora_actual, $fechaAgendada, $horaAgendada, $solicitante, $textObservaciones, $proovedorAgendado)) {
                        $response = 'success';
                    } else {
                        $response = 'error';
                    }
                }
            } else {
                $response = 'fechamenor';
            }
        } else {
            $response = 'required';
        }
        echo $response;

        break;


    case 'agregar_tarjeta':

        $nombreTarjeta = isset($_POST['nombreTarjeta']) ? $_POST['nombreTarjeta'] : '';
        $selectorComprador = isset($_POST['selectorComprador']) ? $_POST['selectorComprador'] : '';
        if (!empty($nombreTarjeta)) {
            if ($bd->agregarTarjeta($nombreTarjeta, $selectorComprador)) {
                $response = 'success';
            } else {
                $response = 'error';
            }
        } else {
            $response = 'required';
        }
        echo $response;
        break;


    case 'obtener_compradores':
        $compradores = $bd->obtenerCompradores($empresaSesion);
        if ($compradores !== false) {
            if (count($compradores) > 0) {
                $response = json_encode($compradores);
            } else {
                $response = 'no-data';
            }
        } else {
            $response = 'error';
        }
        echo $response;

        break;


    case 'editar_tarjeta':

        $ID_tarjetaEdit = isset($_POST['ID_tarjetaEdit']) ? $_POST['ID_tarjetaEdit'] : '';
        $EditnombreTarjeta = isset($_POST['EditnombreTarjeta']) ? $_POST['EditnombreTarjeta'] : '';
        $selectorCompradorEdit = isset($_POST['selectorCompradorEdit']) ? $_POST['selectorCompradorEdit'] : '';

        if (!empty($ID_tarjetaEdit)) {
            if ($bd->editarTarjeta($ID_tarjetaEdit, $EditnombreTarjeta, $selectorCompradorEdit)) {
                $response = 'success';
            } else {
                $response = 'error';
            }
        } else {
            $response = 'required';
        }
        echo $response;
        break;


    case 'eliminar_proveedor':
        $ID_tarjeta = isset($_POST['ID_elim_proveedor']) ? $_POST['ID_elim_proveedor'] : '';
        if (!empty($ID_tarjeta)) {
            if ($bd->eliminarProveedor($ID_tarjeta)) {
                $response = 'success';
            } else {
                $response = 'error';
            }
        } else {
            $response = 'required';
        }
        echo $response;
        break;

    case 'eliminar_solicitud':
        $id = isset($_POST['ID_elim']) ? $_POST['ID_elim'] : '';
        if (!empty($id)) {
            if ($bd->eliminarSolicitud($id)) {
                $response = 'success';
            } else {
                $response = 'error';
            }
        } else {
            $response = 'required';
        }
        echo $response;
        break;

    case 'entregar_solicitud':
        $id = isset($_POST['ID_inventarioEntregar']) ? $_POST['ID_inventarioEntregar'] : '';
        if (!empty($id)) {
            if ($bd->entregarSolicitud($id)) {
                $response = 'success';
            } else {
                $response = 'error';
            }
        } else {
            $response = 'required';
        }
        echo $response;
        break;
        /*
    case 'editar_usuario':
        $ID_usuario = isset($_POST['ID_usuario']) ? $_POST['ID_usuario'] : '';
        $nombre = isset($_POST['nombre_usuario']) ? $_POST['nombre_usuario'] : '';
        $telefono = isset($_POST['telefono_usuario']) ? $_POST['telefono_usuario'] : '';
        $tipo = isset($_POST['tipo_usuario']) ? $_POST['tipo_usuario'] : '';
        if (!empty($idUsuario) && !empty($nombre) && !empty($telefono) && !empty($tipo)){
            $response = $bd->actualizarUsuario($idUsuario, $nombre, $telefono, $tipo) ? 'success' : 'error';
        } else {
            $response = 'required';
        }
        echo $response;
        break;

    case 'ver_password_usuario':
        $ID_usuario = isset($_POST['ID_usuario']) ? $_POST['ID_usuario'] : '';
        if (!empty($ID_usuario)) {
            $passEncript = $bd->obtenerPassword($ID_usuario);
            $response = $bd->decryption($passEncript);
        }else {
            $response = 'required';
        }
        echo $response;
        break;

    case 'obtener_info_usuario':
        $idUsuario = isset($_POST['idUsuario']) ? $_POST['idUsuario'] : '';
        if (!empty($idUsuario)) {
            $usuario = $bd->obtenerInfoUsuario($idUsuario);
            if ($usuario !== false) {
                if (!empty($usuario)) {
                    $response = json_encode($usuario);
                } else {
                    $response = 'no-data';
                }
            } else {
                $response = 'error';
            }
        } else {
            $response = 'required';
        }
        echo $response;
        break;
        */
}
