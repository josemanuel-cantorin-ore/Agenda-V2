<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$accion = isset($_REQUEST['accion']) ? $_REQUEST['accion'] : '';

switch ($accion) {
    case 'login':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->procesarLogin();
        break;

    case 'logout': 
        session_unset();
        session_destroy();
        header("Location: ../app/views/auth/Login.php");
        exit(); 

    case 'inicio':
        header("Location: ../app/views/usuarios/Inicio.php");
        exit();

    case 'guardar_tarea':
        require_once '../app/controllers/TareaController.php';
        $tareaCtrl = new TareaController();
        $tareaCtrl->procesarGuardar();
        break;

    case 'eliminar_tarea':
        require_once '../app/controllers/TareaController.php';
        $tareaCtrl = new TareaController();
        $tareaCtrl->procesarEliminar();
        break;

    case 'eventos':
        header("Location: ../app/views/usuarios/Eventos.php");
        exit();

    case 'guardar_evento':
        require_once '../app/controllers/EventoController.php';
        $eventoCtrl = new EventoController();
        $eventoCtrl->procesarGuardar();
        break;

    case 'eliminar_evento':
        require_once '../app/controllers/EventoController.php';
        $eventoCtrl = new EventoController();
        $eventoCtrl->procesarEliminar();
        break;
    
    case 'registro':
        header("Location: ../app/views/auth/Registro.php");
        exit();

    case 'guardar_usuario':
        require_once '../app/controllers/UsuarioController.php';
        $usuarioCtrl = new UsuarioController();
        $usuarioCtrl->registrarUsuario();
        break;

        default:
        header("Location: ../app/views/auth/Login.php");
        exit(); 
}
?>