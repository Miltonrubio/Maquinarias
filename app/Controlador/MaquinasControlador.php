<?php
session_start();
require "../Modelo/Maquinas.php";

$bd = new Maquinas();

$empresaSesion =   $_SESSION['ID_empresa'];
$ID_sesionIniciada = $_SESSION['ID_usuario'];


switch ($_REQUEST["operador"]) {
    case 'obtener_maquinas':

        $buscadorMaquinas = isset($_POST['buscadorMaquinas']) ? $_POST['buscadorMaquinas'] : '';

        if (!empty($buscadorMaquinas) || $buscadorMaquinas !== "") {

            $usuarios = $bd->obtenerMaquinasConFiltro($buscadorMaquinas);
        } else {

            $usuarios = $bd->obtenerMaquinas();

        }


        if ($usuarios) {
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


    case 'registrar_maquina':

        $nombre_maquina = isset($_POST['nombre_maquina']) ? $_POST['nombre_maquina'] : '';
        $marca_maquina = isset($_POST['marca_maquina']) ? $_POST['marca_maquina'] : '';
        $modelo_maquina = isset($_POST['modelo_maquina']) ? $_POST['modelo_maquina'] : '';
        $num_serie = isset($_POST['num_serie']) ? $_POST['num_serie'] : '';
        $observaciones_maq = isset($_POST['observaciones_maq']) ? $_POST['observaciones_maq'] : '';
        $fecha_adqui = isset($_POST['fecha_adqui']) ? $_POST['fecha_adqui'] : '';
        $foto_maquina = isset($_FILES['foto_maquina']) ? $_FILES['foto_maquina'] : '';


        if (!empty($nombre_maquina)  ||   !empty($marca_maquina)  ||  !empty($modelo_maquina)  ||  !empty($num_serie) ||  !empty($observaciones_maq)  ||  !empty($fecha_adqui) ||  !empty($foto_maquina)) {
            $opcion = 13;

            $nombreFoto = $bd->subirImagenAAPI($foto_maquina, $opcion);
            if (!empty($nombreFoto)) {

                if ($bd->AgregarMaquina($nombre_maquina, $marca_maquina, $modelo_maquina, $num_serie, $observaciones_maq, $fecha_adqui, $empresaSesion, $nombreFoto)) {
                    $response = 'success';
                } else {
                    $response = 'error';
                }
            } else {

                $response = 'Hubo un error con la foto';
            }
        } else {
            $response = 'required';
        }
        echo $response;
        break;



    case 'eliminar_maquina':

        $ID_maquina = isset($_POST['ID_maquina']) ? $_POST['ID_maquina'] : '';
        if (!empty($ID_maquina)) {
            if ($bd->EliminarMaquina($ID_maquina)) {
                $response = 'success';
            } else {
                $response = 'error';
            }
        } else {
            $response = 'required';
        }
        echo $response;
        break;


    case 'editor_maquina':


        $ID_maquina = isset($_POST['id_maquinaEdit']) ? $_POST['id_maquinaEdit'] : '';

        $nombre_maquina = isset($_POST['nombre_maquinaEdit']) ? $_POST['nombre_maquinaEdit'] : '';
        $marca_maquina = isset($_POST['marca_maquinaEdit']) ? $_POST['marca_maquinaEdit'] : '';
        $modelo_maquina = isset($_POST['modelo_maquinaEdit']) ? $_POST['modelo_maquinaEdit'] : '';
        $num_serie = isset($_POST['num_serieEdit']) ? $_POST['num_serieEdit'] : '';
        $observaciones_maq = isset($_POST['observaciones_maqEdit']) ? $_POST['observaciones_maqEdit'] : '';
        $fecha_adqui = isset($_POST['fecha_adquiEdit']) ? $_POST['fecha_adquiEdit'] : '';
        $foto_maquinaEdit = isset($_FILES['foto_maquinaEdit']) ? $_FILES['foto_maquinaEdit'] : '';



        try {
            if (!empty($nombre_maquina)  ||   !empty($marca_maquina)  ||  !empty($modelo_maquina)  ||  !empty($num_serie) ||  !empty($observaciones_maq)  ||  !empty($fecha_adqui)) {


                if (!empty($foto_maquinaEdit['name'])) {


                    $opcion = 13;
                    $nombreFoto = $bd->subirImagenAAPI($foto_maquinaEdit, $opcion);

                    if (!empty($nombreFoto)) {

                        if ($bd->EditarMaquinaConFoto($nombre_maquina, $marca_maquina, $modelo_maquina, $num_serie, $observaciones_maq, $fecha_adqui, $nombreFoto, $ID_maquina)) {
                            $response = 'success';
                        } else {
                            $response = 'error';
                        }
                    } else {

                        $response = 'Hubo un error con la foto';
                    }
                } else {
                    if ($bd->EditarMaquinaSinFoto($nombre_maquina, $marca_maquina, $modelo_maquina, $num_serie, $observaciones_maq, $fecha_adqui, $ID_maquina)) {
                        $response = 'success';
                    } else {
                        $response = 'error';
                    }
                }
            } else {
                $response = 'required';
            }
        } catch (\Throwable $th) {
            $response = 'El error es ' . $th;
        }



        echo $response;
        break;







        /*
    case 'registrar_usuario':
        $nombre = isset($_POST['nombre_usuario']) ? $_POST['nombre_usuario'] : '';
        $telefono = isset($_POST['telefono_usuario']) ? $_POST['telefono_usuario'] : '';
        //$tipo = isset($_POST['tipo_usuario']) ? $_POST['tipo_usuario'] : '';
        $password = isset($_POST['password_usuario']) ? $_POST['password_usuario'] : '';
        $empresa = isset($_POST['empresa']) ? $_POST['empresa'] : '';
        $permisos = isset($_POST['permisos']) ? $_POST['permisos'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        if (!empty($nombre) && !empty($telefono) && !empty($empresa) && !empty($password) && !empty($email)&& !empty($permisos) ) {
            $passHash = $bd->encryption($password);
            if ($bd->existenciaUsuario($telefono)) {
                if ($bd->registrarUsuario  ($nombre, $telefono, $passHash, $empresa, $permisos, $email)){  /*($nombre, $telefono, $tipo, $passHash)){
                    $response = 'success';
                }else {
                    $response = 'error';
                }
            }else {
                $response = 'exist';
            }
        }else {
            $response = 'required';
        }
        echo $response;
        break;

    case 'eliminar_usuario':
        $id = isset($_POST['ID_usuario']) ? $_POST['ID_usuario'] : '';
        if (!empty($id)) {
            if ($bd->desactivarUsuario($id)) {
                $response = 'success';
            }else {
                $response = 'error';
            }
        }else {
            $response = 'required';
        }
        echo $response;
        break;

    case 'editar_usuario':


        $ID_usuario = isset($_POST['ID_usuarioEditar']) ? $_POST['ID_usuarioEditar'] : '';
        $nombre = isset($_POST['nombre_usuario']) ? $_POST['nombre_usuario'] : '';
        $telefono = isset($_POST['telefono_usuarioEdit']) ? $_POST['telefono_usuarioEdit'] : '';
        $emailEdit = isset($_POST['emailEdit']) ? $_POST['emailEdit'] : '';
        $empresaEdit = isset($_POST['empresaEdit']) ? $_POST['empresaEdit'] : '';
        $permisosEdit = isset($_POST['permisosEdit']) ? $_POST['permisosEdit'] : '';

        if (!empty($ID_usuario) && !empty($nombre) && !empty($telefono) && !empty($emailEdit) && !empty($empresaEdit) && !empty($permisosEdit)){
            $response = $bd->actualizarUsuario($ID_usuario, $nombre, $telefono, $emailEdit, $empresaEdit, $permisosEdit) ? 'success' : 'error';
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
        $ID_usuario = isset($_POST['ID_usuario']) ? $_POST['ID_usuario'] : '';
        if (!empty($ID_usuario)) {
            $usuario = $bd->obtenerInfoUsuario($ID_usuario);
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
