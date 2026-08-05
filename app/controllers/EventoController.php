<?php
require_once __DIR__ . '/../models/Eventos.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class EventoController {
    public function procesarGuardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['id_usuario'])) {
            $id_evento = $_POST['id_evento'] ?? null;
            $id_usuario = $_SESSION['id_usuario'];
            $titulo = trim($_POST['titulo_evento']);
            $contenido = trim($_POST['contenido_evento']);
            $fecha = $_POST['fecha'];
            $fecha_fin = !empty($_POST['fecha_finalizacion']) ? $_POST['fecha_finalizacion'] : null;
            $ubicacion = trim($_POST['ubicacion']);
            $repeticion = !empty($_POST['repeticion']) ? $_POST['repeticion'] : null;
            $modeloEvento = new Evento();
            $modeloEvento->guardar($id_evento, $id_usuario, $titulo, $contenido, $fecha, $fecha_fin, $ubicacion, $repeticion);
            header("Location: /Agenda/public/Index.php?accion=eventos");
            exit();
        }
    }
    public function procesarEliminar() {
        if (isset($_GET['id']) && isset($_SESSION['id_usuario'])) {
            $id_evento = $_GET['id'];
            $id_usuario = $_SESSION['id_usuario'];

            $modeloEvento = new Evento();
            $modeloEvento->eliminar($id_evento, $id_usuario);
            
            header("Location: /Agenda/public/Index.php?accion=eventos");
            exit();
        }
    }
}
?>