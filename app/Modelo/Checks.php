<?php
define('METHOD','AES-256-CBC');
define('SECRET_KEY','$CARLOS@2016');
define('SECRET_IV','101712');
require_once "../../config/Conexion.php";

class Checks
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

    function obtenerPlantillas(){
        $query = "SELECT * FROM plantillas_checks ORDER BY ID_plantilla DESC";
        $result = $this->cnx->prepare($query);
        if ($result->execute()) {
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    function subirFotoMaquina($foto){

        $postData = array(
            'method' => 'post',
            'opcion' => 13,
            'image' => new CURLFile($foto['tmp_name'])
        );

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, URLAPIIMG);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);

        $response = curl_exec($curl);

        //Error en la subida de imagenes
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            throw new Exception($error, 1);
        }

        curl_close($curl);

        // Procesar la respuesta de la API y obtener el nombre del archivo subido
        $uploadedFileName = $response;
        if ($uploadedFileName === 'fallo') {
            throw new Exception("Falló al subir la imagen", 1);
        } else{
            return $uploadedFileName;
        }
    }

    function registrarPlantilla($nombre, $foto){
        $query = "INSERT INTO plantillas_checks (nombre_plantilla, foto) VALUES (:nombre, :foto)";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':nombre', $nombre);
        $result->bindParam(':foto', $foto);
        $result->execute();
    }

    function obtenerChecksPlantilla($idPlantilla){
        $query = "SELECT * FROM nombres_checks WHERE ID_plantilla = :idPlantilla AND status_nombre_check = 1";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':idPlantilla', $idPlantilla);
        if ($result->execute()) {
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    function registrarCheckPlantilla($idPlantilla, $check){
        $query = "INSERT INTO nombres_checks (ID_plantilla, nombre_checks) VALUES (:idPlantilla, :check)";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':idPlantilla', $idPlantilla);
        $result->bindParam(':check', $check);
        return $result->execute();
    }
}