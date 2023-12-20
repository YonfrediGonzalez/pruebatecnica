<?php

class FuncionesBD
{

    public static function obtenerVuelos()
    {
        $conn = CConexion::conexionBD();
        $query = "SELECT * FROM public.vuelos ORDER BY id ASC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function crearVuelo($datos)
    {
        $conn = CConexion::conexionBD();
    
        $query = "INSERT INTO public.vuelos (numero_vuelo, fecha_vuelo, empresa, h_salida, h_llegada, aeropuerto_salida, aeropuerto_llegada)
                  VALUES (:numero_vuelo, :fecha_vuelo, :empresa, :h_salida, :h_llegada, :aeropuerto_salida, :aeropuerto_llegada)";
    
        $stmt = $conn->prepare($query);
        return $stmt->execute($datos);
    }

    public static function actualizarVuelo($id, $datos)
    {
        $conn = CConexion::conexionBD();

        $query = "UPDATE public.vuelos
                  SET numero_vuelo = :numero_vuelo, fecha_vuelo = :fecha_vuelo, empresa = :empresa,
                      h_salida = :h_salida, h_llegada = :h_llegada, aeropuerto_salida = :aeropuerto_salida,
                      aeropuerto_llegada = :aeropuerto_llegada
                  WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Bind de los demás parámetros
        $stmt->bindParam(':numero_vuelo', $datos['numero_vuelo'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_vuelo', $datos['fecha_vuelo'], PDO::PARAM_STR);
        $stmt->bindParam(':empresa', $datos['empresa'], PDO::PARAM_STR);
        $stmt->bindParam(':h_salida', $datos['h_salida'], PDO::PARAM_STR);
        $stmt->bindParam(':h_llegada', $datos['h_llegada'], PDO::PARAM_STR);
        $stmt->bindParam(':aeropuerto_salida', $datos['aeropuerto_salida'], PDO::PARAM_STR);
        $stmt->bindParam(':aeropuerto_llegada', $datos['aeropuerto_llegada'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function eliminarVuelo($id)
    {
        $conn = CConexion::conexionBD();

        $query = "DELETE FROM public.vuelos WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
