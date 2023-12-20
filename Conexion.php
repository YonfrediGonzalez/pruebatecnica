<?php

class CConexion {

    function conexionBD() {

        $host = "localhost";
        $dbname = "TECHNOKEY";
        $user = "postgres";
        $password = "root";

        try {
            $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
           
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "";
        } catch (PDOException $exp) {
            echo "No se pudo conectar a la base de datos: " . $exp->getMessage();
        }

        return $conn;

    }

}

?>