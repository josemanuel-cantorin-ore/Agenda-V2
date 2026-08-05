<?php
require_once __DIR__ . '/../../config/Conexion.php';

class Tarea {
    private $conexion;

    public function __construct() {
        $conexion = new Conexion();
        $this->conexion = $conexion->conectar();
    }
    public function obtenerTareasPorUsuario($id_usuario) {
        try {
            $sql = "SELECT * FROM tareas_pendientes WHERE id_usuario = :id_usuario ORDER BY fecha_limite ASC";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ); 
        } catch(PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    public function guardar($id_tp, $id_usuario, $nombre, $contenido, $estado, $prioridad, $fecha_limite) {
        try {
            if (!empty($id_tp)) {
                $sql = "UPDATE tareas_pendientes SET nombre_tarea = :nombre, contenido_tarea = :contenido, 
                        estado_tarea = :estado, prioridad = :prioridad, fecha_limite = :fecha_limite 
                        WHERE id_tp = :id_tp AND id_usuario = :id_usuario";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':id_tp', $id_tp, PDO::PARAM_INT);
            } else {
                $sql = "INSERT INTO tareas_pendientes (id_usuario, nombre_tarea, contenido_tarea, estado_tarea, prioridad, fecha_limite) 
                        VALUES (:id_usuario, :nombre, :contenido, :estado, :prioridad, :fecha_limite)";
                $stmt = $this->conexion->prepare($sql);
            }
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':contenido', $contenido, PDO::PARAM_STR);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
            $stmt->bindParam(':prioridad', $prioridad, PDO::PARAM_STR);
            if (empty($fecha_limite)) {
                $stmt->bindValue(':fecha_limite', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindParam(':fecha_limite', $fecha_limite, PDO::PARAM_STR);
            }
            return $stmt->execute();
        } catch(PDOException $e) {
            die("Error al guardar: " . $e->getMessage());
        }
    }
    public function eliminar($id_tp, $id_usuario) {
        try {
            $sql = "DELETE FROM tareas_pendientes WHERE id_tp = :id_tp AND id_usuario = :id_usuario";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_tp', $id_tp, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            return $stmt->execute();
        } catch(PDOException $e) {
            die("Error al eliminar: " . $e->getMessage());
        }
    }
}
?>