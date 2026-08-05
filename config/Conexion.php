<?php
class Conexion{
    private $host = "localhost";
    private $db_name = "agenda_electronica";
    private $username = "root";
    private $password = "";
    public $conexion;

    public function conectar(){
        $this->conexion = null;

        try{
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conexion = new PDO($dsn, $this->username, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }catch(PDOException $exception){
            echo"Error de conexion a la base de datos: " . $exception->getMessage();
        }
        return $this->conexion;
    }


}


?>