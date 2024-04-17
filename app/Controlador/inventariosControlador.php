<?php
session_start();
require "../Modelo/inventarios.php";
$empresaSesion =   $_SESSION['ID_empresa'];
$ID_sesionIniciada = $_SESSION['ID_usuario']  ;


$bd = new Admin();;

switch ($_REQUEST["operador"]) {
    case 'obtener_solicitudes':
        $usuarios = $bd->obtenerSolcilitudes();
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

    case 'registrar_usuario':
        $nombre = isset($_POST['nombre_usuario']) ? $_POST['nombre_usuario'] : '';
        $telefono = isset($_POST['telefono_usuario']) ? $_POST['telefono_usuario'] : '';
        //$tipo = isset($_POST['tipo_usuario']) ? $_POST['tipo_usuario'] : '';
        $password = isset($_POST['password_usuario']) ? $_POST['password_usuario'] : '';
        $empresa = isset($_POST['empresa']) ? $_POST['empresa'] : '';
        $permisos = isset($_POST['permisos']) ? $_POST['permisos'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        if (!empty($nombre) && !empty($telefono) && !empty($empresa) && !empty($password) && !empty($email) && !empty($permisos)) {
            $passHash = $bd->encryption($password);
            if ($bd->existenciaUsuario($telefono)) {
                if ($bd->registrarUsuario($nombre, $telefono, $passHash, $empresa, $permisos, $email)) {  /*($nombre, $telefono, $tipo, $passHash)){*/
                    $response = 'success';
                } else {
                    $response = 'error';
                }
            } else {
                $response = 'exist';
            }
        } else {
            $response = 'required';
        }
        echo $response;
        break;

    case 'rechazar_solicitud':
        $IDRechazo = isset($_POST['IDRechazo']) ? $_POST['IDRechazo'] : '';
        $motivoRechazo = isset($_POST['motivoRechazo']) ? $_POST['motivoRechazo'] : '';
        if (!empty($IDRechazo)) {
            if ($bd->rechazarSolicitud($IDRechazo, $motivoRechazo, $ID_sesionIniciada)) {
                $response = 'success';
            } else {
                $response = 'error';
            }
        } else {
            $response = 'required';
        }
        echo $response;
        break;
        case 'agregar_evidencias':
            $ID_solicitudEvi = isset($_POST['ID_solicitudEvi']) ? $_POST['ID_solicitudEvi'] : '';
            if(isset($_FILES['evidencias']) && $_FILES['evidencias']['error'] === 0) {
                $file = $_FILES['evidencias'];
                
                $file_name = $file['name'];
                $file_tmp = $file['tmp_name'];
                
                $destination = '../../evidencias/' . $file_name;
                move_uploaded_file($file_tmp, $destination);
                
                if (!empty($ID_solicitudEvi)) {
                    if ($bd->agregarEvidencia($ID_solicitudEvi, $file_name)) {  /*, $destination */
                        $response = 'success';
                    } else {
                        $response = 'error';
                    }
                } else {
                    $response = 'required';
                }
            } else {
                $response = 'error_upload';
            }
            echo $response;
            break;
        

    case 'restaurar_solicitud':
        $id = isset($_POST['ID_inventario']) ? $_POST['ID_inventario'] : '';
        if (!empty($id)) {
            if ($bd->restaurarSolicitud($id)) {
                $response = 'success';
            } else {
                $response = 'error';
            }
        } else {
            $response = 'required';
        }
        echo $response;
        break;

case 'eliminar_evidencia':
    
    $ID_elim = isset($_POST['ID_elim']) ? $_POST['ID_elim'] : '';
    if (!empty($ID_elim)) {
        if ($bd->eliminarEvidencia($ID_elim)) {
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


        
    case 'obtener_evidencias':
        if (isset($_POST['ID_solicitud'])) {
            $ID_solicitud = $_POST['ID_solicitud'];
            // Aquí puedes usar $ID_anomalia en tu modelo para obtener las anomalías específicas
        } else {
            // Si no se proporcionó ID_anomalia, puedes manejar este caso como lo hacías antes
            $ID_solicitud = ''; // O algún valor predeterminado que tenga sentido para tu lógica
        }

        $evidencias = $bd->obtenerEvidenciasCompradores($ID_solicitud);
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

}
