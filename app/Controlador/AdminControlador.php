<?php
session_start();
require "../Modelo/Admin.php";

$bd = new Admin();

switch ($_REQUEST["operador"]) {
    case 'obtener_usuarios':
        $usuarios = $bd->obtenerUsuarios();
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
        if (!empty($nombre) && !empty($telefono) && !empty($empresa) && !empty($password) && !empty($email)&& !empty($permisos) ) {
            $passHash = $bd->encryption($password);
            if ($bd->existenciaUsuario($telefono)) {
                if ($bd->registrarUsuario  ($nombre, $telefono, $passHash, $empresa, $permisos, $email)){  /*($nombre, $telefono, $tipo, $passHash)){*/ 
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

/*

            $('#editar_nombre_usuario').val(usuario.nombre);
            $('#telefono_usuarioEdit').val(usuario.telefono);
            $('#emailEdit').val(usuario.email);
            $('#empresaEdit').val(usuario.empresa);
            $('#permisosEdit').val(usuario.permisos);
*/


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
}