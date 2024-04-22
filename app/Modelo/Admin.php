<?php
define('METHOD','AES-256-CBC');
define('SECRET_KEY','$CARLOS@2016');
define('SECRET_IV','101712');
require_once "../../config/Conexion.php";

class Admin
{

    public $cnx;

    function __construct()
    {
        $this->cnx = Conexion::ConectarDB();
    }

     // Método para comenzar una transacción
    public function beginTransaction()
    {
        $this->cnx->beginTransaction();
    }

     // Método para confirmar la transacción
    public function commit()
    {
        $this->cnx->commit();
    }

     // Método para revertir la transacción
    public function rollBack()
    {
        $this->cnx->rollBack();
    }

    function obtenerUsuarios(){
        $query = "SELECT * FROM usuarios WHERE status_usuario = 1 ORDER BY ID_usuario DESC";
        $result = $this->cnx->query($query);
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {
                    $datos[] = $fila;
                }
                return $datos;
            } else {
                return [];
            }
        } else {
            return false;
        }
    }
    /*

    function registrarUsuario($nombre, $telefono, $tipo, $password){
        $query = "INSERT INTO usuarios (telefono, nombre, password, tipo) VALUES (:telefono, :nombre, :password, :tipo)";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':telefono', $telefono);
        $result->bindParam(':nombre', $nombre);
        $result->bindParam(':password', $password);
        $result->bindParam(':tipo', $tipo);
        return $result->execute();
    }
*/
function registrarUsuario($nombre, $telefono, $clave, $empresa, $permisos, $email){
    $status_usuario=1;
    $query = "INSERT INTO usuarios (telefono, nombre, clave, empresa, permisos, status_usuario, email) VALUES (:telefono, :nombre, :clave, :empresa, :permisos, :status_usuario, :email)";
    $result = $this->cnx->prepare($query);
    $result->bindParam(':telefono', $telefono);
    $result->bindParam(':nombre', $nombre);
    $result->bindParam(':clave', $clave);
    $result->bindParam(':empresa', $empresa);
    $result->bindParam(':permisos', $permisos);
    $result->bindParam(':status_usuario', $status_usuario);
    $result->bindParam(':email', $email);
    return $result->execute();
}

    function desactivarUsuario($ID_usuario){
        $query = "UPDATE usuarios SET status_usuario = 0 WHERE ID_usuario = :ID_usuario";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':ID_usuario', $ID_usuario);
        return $result->execute();
    }

    function existenciaUsuario($telefono){
        $query = "SELECT * FROM usuarios WHERE telefono = :telefono AND status_usuario = 1";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':telefono', $telefono);
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    function encryption($string){
        $output=FALSE;
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output=base64_encode($output);
        return $output;
    }

    public static function decryption($string){
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    function obtenerPassword($ID_usuario){
        $query = "SELECT clave FROM usuarios WHERE ID_usuario = :ID_usuario";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':ID_usuario', $ID_usuario);
        $result->execute();
        $fila = $result->fetch();
        return $fila['clave'];
    }

    function obtenerInfoUsuario($ID_usuario){
        $query = "SELECT * FROM usuarios WHERE ID_usuario = :ID_usuario";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':ID_usuario', $ID_usuario);
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                $datos = $result->fetch(PDO::FETCH_ASSOC);
                return $datos;
            } else {
                return [];
            }
        }else {
            return false;
        }
    }

    function actualizarUsuario($ID_usuario, $nombre, $telefono, $emailEdit, $empresaEdit, $permisosEdit){
        $query = "UPDATE usuarios SET nombre = :nombre, telefono = :telefono, email= :emailEdit, empresa = :empresaEdit, permisos= :permisosEdit  WHERE ID_usuario = :ID_usuario";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':ID_usuario', $ID_usuario);
        $result->bindParam(':nombre', $nombre);
        $result->bindParam(':telefono', $telefono);
        $result->bindParam(':emailEdit', $emailEdit);
        $result->bindParam(':empresaEdit', $empresaEdit);
        $result->bindParam(':permisosEdit', $permisosEdit);
        return $result->execute();
    }

    function login($phone, $password) {
        $query = "SELECT * FROM usuarios 
        LEFT JOIN empresa ON  empresa.ID_empresa =  usuarios.empresa
        WHERE usuarios.telefono = :telefono AND usuarios.status_usuario = 1";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':telefono', $phone);
        if ($result->execute()) {
            $user = $result->fetch(PDO::FETCH_ASSOC);
            if ($user['clave'] === $password) {
                return $user;
            }else {
                return 'not-found';
            }
        }else {
            return false;
        }
    }
}