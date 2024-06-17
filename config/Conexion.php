<?php

class Conexion {

    static function ConectarDB()
    {
        try {

            require "Global.php";

            $cnx = new PDO(DSN,USERNAME,PASSWORD);
            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $cnx;

        } catch (PDOException $ex) {
            // Aquí puedes manejar la excepción de manera más controlada
            // Por ejemplo, registrando el error en un archivo de registro
            error_log('Error de conexión a la base de datos: ' . $ex->getMessage());
            // Puedes lanzar una excepción o devolver null o algún valor indicando un error
            throw $ex; // Lanza la excepción para que la maneje el código que llama a ConectarDB
        }


    }


}

?>

