<?php
require_once __DIR__ . '/../models/Tareas.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class TareaController {
    public function procesarGuardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['id_usuario'])) {
            $id_tp = $_POST['id_tp'] ?? null; 
            $id_usuario = $_SESSION['id_usuario'];
            $nombre = trim($_POST['nombre_tarea']);
            $contenido = trim($_POST['contenido_tarea']);
            $estado = $_POST['estado_tarea'];
            $prioridad = $_POST['prioridad'];
            $fecha_limite = !empty($_POST['fecha_limite']) ? $_POST['fecha_limite'] : null;
            $modeloTarea = new Tarea();
            $modeloTarea->guardar($id_tp, $id_usuario, $nombre, $contenido, $estado, $prioridad, $fecha_limite);
            header("Location: /Agenda/public/Index.php?accion=inicio");
            exit();
        }
    }
    public function procesarEliminar() {
        if (isset($_GET['id']) && isset($_SESSION['id_usuario'])) {
            $id_tp = $_GET['id'];
            $id_usuario = $_SESSION['id_usuario'];

            $modeloTarea = new Tarea();
            $modeloTarea->eliminar($id_tp, $id_usuario);
            
            header("Location: /Agenda/public/Index.php?accion=inicio");
            exit();
        }
    }
}
?>