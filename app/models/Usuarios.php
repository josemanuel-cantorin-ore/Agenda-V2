<?php
require_once __DIR__ . '/../../config/Conexion.php';

class Usuario {
    private $conexion;

    public function __construct(){
        $conexion = new Conexion();
        $this->conexion = $conexion->conectar();
    }
    public function buscarPorUsuario($usuario){
        try{
            $sql = "SELECT id_usuario, nombre_usuario, apellidos, numero_telefono, correo, contrasena 
                    FROM usuarios WHERE nombre_usuario = :usuario";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ); 
        } catch(PDOException $e){
            die("Error en la consulta: " . $e->getMessage());
        }}
    public function insertar($nombre, $apellidos, $telefono, $correo, $password_hash) {
        try {
            $sql = "INSERT INTO usuarios (nombre_usuario, apellidos, numero_telefono, correo, contrasena) 
                    VALUES (:nombre, :apellidos, :telefono, :correo, :contrasena)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->bindParam(':contrasena', $password_hash, PDO::PARAM_STR);
            return $stmt->execute();
        } catch(PDOException $e) {
            if ($e->getCode() == 23000) {
                return false; 
            }
            die("Error al registrar usuario: " . $e->getMessage());
        }
    }
}
?>