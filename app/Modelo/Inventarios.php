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

    function obtenerSolcilitudes(){
        /*
        $query = "SELECT solicitudes.*, usuarios.nombre, usuarios.empresa
        FROM solicitudes
        INNER JOIN usuarios ON solicitudes.ID_quien_solicita = usuarios.ID_usuario  
        WHERE status_solicitud != 'Eliminado' ORDER BY ID_solicitud DESC";

        */
$query="SELECT solicitudes.*, usuarios.nombre, usuarios.empresa, tarjetas.nombre_proveedor AS tarjeta
FROM solicitudes
INNER JOIN usuarios ON solicitudes.ID_quien_solicita = usuarios.ID_usuario  
INNER JOIN tarjetas ON tarjetas.ID_tarjeta = solicitudes.ID_tarjeta  
WHERE status_solicitud != 'Eliminado' ORDER BY ID_solicitud DESC";

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

/*
function rechazarSolicitud($ID_solicitud, $motivoRechazo){
    $query = "UPDATE solicitudes SET status_solicitud = 'Rechazado' WHERE ID_solicitud = :ID_solicitud";
    $result = $this->cnx->prepare($query);
    $result->bindParam(':ID_solicitud', $ID_solicitud);
    return $result->execute();
}
*/
function rechazarSolicitud($ID_solicitud, $motivoRechazo, $ID_sesion_iniciada){
    $query1 = "UPDATE solicitudes SET status_solicitud = 'Rechazado' WHERE ID_solicitud = :ID_solicitud";
    $result1 = $this->cnx->prepare($query1);
    $result1->bindParam(':ID_solicitud', $ID_solicitud);
    $success1 = $result1->execute();

    // Verificar si la primera consulta se ejecutó correctamente
    if ($success1) {
        // Segunda consulta para insertar una nueva anomalía
        $query2 = "INSERT INTO `anomalias`(`observaciones`, `ID_quien_reporto`, `ID_solicitud`, `status_anomalia`) VALUES (:motivoRechazo, :ID_sesion_iniciada, :ID_solicitud, 1)";
        $result2 = $this->cnx->prepare($query2);
        $result2->bindParam(':motivoRechazo', $motivoRechazo);
        $result2->bindParam(':ID_sesion_iniciada', $ID_sesion_iniciada);
        $result2->bindParam(':ID_solicitud', $ID_solicitud);
        return $result2->execute();
    } else {
        // La primera consulta no se ejecutó correctamente, puedes manejar el error aquí si es necesario
        return 'error';
    }
}



function agregarEvidencia($ID_solicitud, $evidencias){
    $query = "INSERT INTO `evidencias`(`ruta_evidencia`, `fecha_evidencia`, `ID_solicitud`, `status_evidencia`, `tipo`) VALUES (:evidencias, now(), :ID_solicitud, 1, 'Salida' )";
    $result = $this->cnx->prepare($query);
    $result->bindParam(':ID_solicitud', $ID_solicitud);
    $result->bindParam(':evidencias', $evidencias);
    return $result->execute();
}

function eliminarEvidencia($ID_evidencia)
{
    $query = "UPDATE evidencias SET status_evidencia=0 WHERE ID_evidencia = :ID_evidencia ";
    $result = $this->cnx->prepare($query);
    $result->bindParam(':ID_evidencia', $ID_evidencia);
    return $result->execute();

}


function restaurarSolicitud($ID_solicitud){
    $query = "UPDATE solicitudes SET status_solicitud = 'Pendiente' WHERE ID_solicitud = :ID_solicitud";
    $result = $this->cnx->prepare($query);
    $result->bindParam(':ID_solicitud', $ID_solicitud);
    return $result->execute();
}

function entregarSolicitud($ID_solicitud){
    $query = "UPDATE solicitudes SET status_solicitud = 'Entregado' WHERE ID_solicitud = :ID_solicitud";
    $result = $this->cnx->prepare($query);
    $result->bindParam(':ID_solicitud', $ID_solicitud);
    return $result->execute();
}



/*
    function desactivarUsuario($ID_usuario){
        $query = "UPDATE usuarios SET status_usuario = 0 WHERE ID_usuario = :ID_usuario";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':ID_usuario', $ID_usuario);
        return $result->execute();
    }
*/
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

    function obtenerEvidenciasCompradores($ID_solicitud)
    {
        $query = "SELECT  * FROM evidencias WHERE  status_evidencia=1 && ID_solicitud= $ID_solicitud ORDER BY ID_evidencia  DESC";
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

}