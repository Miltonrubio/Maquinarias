<?php
define('METHOD', 'AES-256-CBC');
define('SECRET_KEY', '$CARLOS@2016');
define('SECRET_IV', '101712');
require_once "../../config/Conexion.php";

class Maquinas
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

    function obtenerMaquinas()
    {
        $query = "SELECT * FROM maquinas
        LEFT JOIN empresa ON empresa.ID_empresa = maquinas.empresa
         WHERE status_maquina = 1 ORDER BY ID_maquina DESC";
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

//Agregue esta funcion
    function Consultarusurio($telefono, $clave)
    {
        $query = "SELECT * FROM usuarios 
        LEFT JOIN empresa ON empresa.ID_empresa = usuarios.empresa
        WHERE telefono = :telefono AND clave= :clave AND status_usuario = 1 ";
        $result = $this->cnx->prepare($query);
        $result->bindParam(":telefono", $telefono);
        $result->bindParam(":clave", $clave);
        $result->execute();
    
        if ($result->rowCount() > 0) {
            while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {
                $datos[] = $fila;
            }
            return $datos;
        } else {
            if ($result->rowCount() === 0) {
                return [];
            } else {
                return "No hay datos";
            }
        }
    }



    function obtenerMaquinasConFiltro($buscadorMaquinas)
    {
        $query = "SELECT * FROM maquinas
        LEFT JOIN empresa ON empresa.ID_empresa = maquinas.empresa
         WHERE status_maquina = 1 AND  ( maquinas.nombre_maquina like '%$buscadorMaquinas%' OR  maquinas.marca like '%$buscadorMaquinas%'  OR  maquinas.modelo like '%$buscadorMaquinas%' OR  maquinas.nserie like '%$buscadorMaquinas%'  OR  maquinas.observaciones like  '%$buscadorMaquinas%')   ORDER BY ID_maquina DESC";
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


    function EditarMaquinaConFoto($nombre_maquina, $marca_maquina, $modelo_maquina, $num_serie, $observaciones_maq, $fecha_adqui, $nombreFoto, $ID_maquina)
    {


        $query = "UPDATE maquinas SET nombre_maquina= :nombre_maquina , marca= :marca_maquina, modelo= :modelo_maquina , nserie= :num_serie, observaciones= :observaciones_maq , fecha_compra = :fecha_adqui , foto_maquina = :nombreFoto WHERE ID_maquina = :ID_maquina ";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':nombre_maquina', $nombre_maquina);
        $result->bindParam(':marca_maquina', $marca_maquina);
        $result->bindParam(':modelo_maquina', $modelo_maquina);
        $result->bindParam(':num_serie', $num_serie);
        $result->bindParam(':observaciones_maq', $observaciones_maq);
        $result->bindParam(':fecha_adqui', $fecha_adqui);
        $result->bindParam(':nombreFoto', $nombreFoto);
        $result->bindParam(':ID_maquina', $ID_maquina);
        if ($result->execute()) {
            return true;
        } else {
            return false;
        }
    }





    function EditarMaquinaSinFoto($nombre_maquina, $marca_maquina, $modelo_maquina, $num_serie, $observaciones_maq, $fecha_adqui, $ID_maquina)
    {
        $query = "UPDATE maquinas SET nombre_maquina= :nombre_maquina , marca= :marca_maquina, modelo= :modelo_maquina , nserie= :num_serie, observaciones= :observaciones_maq , fecha_compra = :fecha_adqui WHERE ID_maquina = :ID_maquina ";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':nombre_maquina', $nombre_maquina);
        $result->bindParam(':marca_maquina', $marca_maquina);
        $result->bindParam(':modelo_maquina', $modelo_maquina);
        $result->bindParam(':num_serie', $num_serie);
        $result->bindParam(':observaciones_maq', $observaciones_maq);
        $result->bindParam(':fecha_adqui', $fecha_adqui);
        $result->bindParam(':ID_maquina', $ID_maquina);

        if ($result->execute()) {
            return true;
        } else {
            return false;
        }
    }



    function AgregarMaquina($nombre_maquina, $marca_maquina, $modelo_maquina, $num_serie, $observaciones_maq, $fecha_adqui, $empresa, $nombreFoto)
    {
        $status_maquina = 1;
        $query = "INSERT INTO `maquinas` (`nombre_maquina`, `marca`, `modelo`, `nserie`, `observaciones`, `fecha_compra`, `status_maquina`, `empresa`, `foto_maquina` ) VALUES (:nombre_maquina, :marca_maquina, :modelo_maquina, :num_serie, :observaciones_maq, :fecha_adqui, :status_maquina, :empresa, :nombreFoto)";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':nombre_maquina', $nombre_maquina);
        $result->bindParam(':marca_maquina', $marca_maquina);
        $result->bindParam(':modelo_maquina', $modelo_maquina);
        $result->bindParam(':num_serie', $num_serie);
        $result->bindParam(':observaciones_maq', $observaciones_maq);
        $result->bindParam(':fecha_adqui', $fecha_adqui);
        $result->bindParam(':status_maquina', $status_maquina);
        $result->bindParam(':empresa', $empresa);
        $result->bindParam(':nombreFoto', $nombreFoto);
        if ($result->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Cambie esta funcion

    function EliminarMaquina($ID_maquina)
    {

        $query = "UPDATE maquinas SET status_maquina = 0 WHERE ID_maquina = $ID_maquina";
        $result = $this->cnx->prepare($query);
        if ($result->execute() &&  $result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }




    function subirImagenAAPI($foto, $opcion)
    {
        $apiUrl = 'http://tallergeorgio.hopto.org:5613/tallergeorgio/api/subirimagenes.php';
        $method = 'post';

        $postData = array(
            'method' => $method,
            'opcion' => $opcion,
            'image' => new CURLFile($foto['tmp_name'])
        );

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);

        $response = curl_exec($curl);

        //Error en la subida de imagenes
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            return false;
        }

        curl_close($curl);

        // Procesar la respuesta de la API y obtener el nombre del archivo subido
        $uploadedFileName = $response;
        return $uploadedFileName;
    }
}
