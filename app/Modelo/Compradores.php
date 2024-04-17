<?php


define('METHOD', 'AES-256-CBC');
define('SECRET_KEY', '$CARLOS@2016');
define('SECRET_IV', '101712');
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


    function obtenerTarjetas($empresa)
    {
        $query = "SELECT * FROM tarjetas
        INNER JOIN compradores ON tarjetas.ID_comprador = compradores.ID_comprador  
        WHERE status_proveedor=1 AND  empresa like '$empresa' 
        ORDER BY ID_tarjeta  DESC";

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


    function obtenerCompradores($empresa)
    {
        $query = "SELECT * FROM compradores 
        WHERE status_comprador=1 AND  empresa like '$empresa' 
          ORDER BY ID_comprador  DESC";
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
    function obtenerEvidencias($ID_solicitud)
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


    function obtenerAnomalias($ID_solicitud)
    {
        $query = "SELECT anomalias.*, usuarios.nombre
     FROM anomalias
     INNER JOIN usuarios ON anomalias.ID_quien_reporto = usuarios.ID_usuario  
     WHERE ID_solicitud= $ID_solicitud AND status_anomalia=1  ORDER BY ID_anomalia  DESC";
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


    function obtenerSolcilitudesPorTipoUsuario($empresa)
    {
        $query = "SELECT solicitudes.*, compradores.nombreComprador AS nombre, compradores.empresa, tarjetas.nombre_proveedor AS tarjeta
        FROM solicitudes
        INNER JOIN compradores ON solicitudes.ID_quien_solicita = compradores.ID_comprador  
        INNER JOIN tarjetas ON tarjetas.ID_tarjeta = solicitudes.ID_tarjeta  
        WHERE status_solicitud != 'Eliminado' AND empresa like '$empresa'  ORDER BY ID_solicitud DESC";
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


    function agregarTarjeta($nombreTarjeta, $ID_comprador)
    {
        $query = "INSERT INTO tarjetas  (nombre_proveedor, status_proveedor, ID_comprador) VALUES (:nombreTarjeta, 1, :ID_comprador)";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':nombreTarjeta', $nombreTarjeta);
        $result->bindParam(':ID_comprador', $ID_comprador);
        return $result->execute();
    }


    function agregarSolicitud($fecha_hora_actual,  $fecha_requerido, $hora_requerido, $ID_quien_solicita, $observaciones, $ID_tarjeta)
    {

        $status_solicitud = 'Pendiente';



        $query = "INSERT INTO `solicitudes`(`fecha_solicitud`, `fecha_requerido`, `hora_requerido`, `ID_quien_solicita`, `status_solicitud`, `observaciones`, `ID_tarjeta`)
         VALUES (:fecha_hora_actual, :fecha_requerido,:hora_requerido, :ID_quien_solicita, :status_solicitud,  :observaciones, :ID_tarjeta)";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':fecha_hora_actual', $fecha_hora_actual);
        $result->bindParam(':fecha_requerido', $fecha_requerido);
        $result->bindParam(':hora_requerido', $hora_requerido);
        $result->bindParam(':ID_quien_solicita', $ID_quien_solicita);
        $result->bindParam(':status_solicitud', $status_solicitud);
        $result->bindParam(':observaciones', $observaciones);
        $result->bindParam(':ID_tarjeta', $ID_tarjeta);
        return $result->execute();
    }


    function  editarTarjeta($ID_tarjeta, $nombreTarjeta, $ID_comprador)
    {

        $query = "UPDATE tarjetas SET nombre_proveedor=:nombreTarjeta, ID_comprador =:ID_comprador  WHERE ID_tarjeta= :ID_tarjeta";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':nombreTarjeta', $nombreTarjeta);
        $result->bindParam(':ID_comprador', $ID_comprador);
        $result->bindParam(':ID_tarjeta', $ID_tarjeta);

        return $result->execute();
    }


    function eliminarProveedor($ID_tarjeta)
    {
        $query = "UPDATE `tarjetas` SET `status_proveedor`= 0 WHERE ID_tarjeta = :ID_tarjeta";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':ID_tarjeta', $ID_tarjeta);
        return $result->execute();
    }


    function eliminarSolicitud($ID_solicitud)
    {
        $query = "UPDATE solicitudes SET status_solicitud = 'Eliminado' WHERE ID_solicitud = :ID_solicitud";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':ID_solicitud', $ID_solicitud);
        return $result->execute();
    }

    function entregarSolicitud($ID_solicitud)
    {
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
    function existenciaUsuario($telefono)
    {
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

    function encryption($string)
    {
        $output = FALSE;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    public static function decryption($string)
    {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

}
