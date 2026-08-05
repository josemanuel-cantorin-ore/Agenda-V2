<?php
require_once __DIR__ . '/../../config/Conexion.php';

class Evento {
    private $conexion;

    public function __construct() {
        $conexion = new Conexion();
        $this->conexion = $conexion->conectar();
    }
    public function obtenerEventosPorUsuario($id_usuario) {
        try {
            $sql = "SELECT * FROM eventos WHERE id_usuario = :id_usuario ORDER BY fecha ASC";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ); 
        } catch(PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    public function guardar($id_evento, $id_usuario, $titulo, $contenido, $fecha, $fecha_fin, $ubicacion, $repeticion) {
        try {
            if (!empty($id_evento)) {
                $sql = "UPDATE eventos SET titulo_evento = :titulo, contenido_evento = :contenido, 
                        fecha = :fecha, fecha_finalizacion = :fecha_fin, ubicacion = :ubicacion, repeticion = :repeticion 
                        WHERE id_evento = :id_evento AND id_usuario = :id_usuario";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':id_evento', $id_evento, PDO::PARAM_INT);
            } else {
                $sql = "INSERT INTO eventos (id_usuario, titulo_evento, contenido_evento, fecha, fecha_finalizacion, ubicacion, repeticion) 
                        VALUES (:id_usuario, :titulo, :contenido, :fecha, :fecha_fin, :ubicacion, :repeticion)";
                $stmt = $this->conexion->prepare($sql);
            }
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmt->bindParam(':contenido', $contenido, PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            
            // Campos que pueden ser nulos
            empty($fecha_fin) ? $stmt->bindValue(':fecha_fin', null, PDO::PARAM_NULL) : $stmt->bindParam(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
            empty($ubicacion) ? $stmt->bindValue(':ubicacion', null, PDO::PARAM_NULL) : $stmt->bindParam(':ubicacion', $ubicacion, PDO::PARAM_STR);
            empty($repeticion) ? $stmt->bindValue(':repeticion', null, PDO::PARAM_NULL) : $stmt->bindParam(':repeticion', $repeticion, PDO::PARAM_STR);

            return $stmt->execute();
        } catch(PDOException $e) {
            die("Error al guardar evento: " . $e->getMessage());
        }
    }
    public function eliminar($id_evento, $id_usuario) {
        try {
            $sql = "DELETE FROM eventos WHERE id_evento = :id_evento AND id_usuario = :id_usuario";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_evento', $id_evento, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            return $stmt->execute();
        } catch(PDOException $e) {
            die("Error al eliminar evento: " . $e->getMessage());
        }
    }
}
?>