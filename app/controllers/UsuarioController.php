<?php
require_once __DIR__ . '/../models/Usuarios.php';

class UsuarioController {
    public function registrarUsuario() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = trim($_POST['nombre']);
            $apellidos = trim($_POST['apellidos']);
            $telefono = trim($_POST['telefono']);
            $correo = trim($_POST['correo']);
            $password = $_POST['password'];
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $modeloUsuario = new Usuario();
            $resultado = $modeloUsuario->insertar($nombre, $apellidos, $telefono, $correo, $password_hash);

            if ($resultado) {
                echo "<script>alert('Usuario registrado exitosamente.'); window.location.href='/Agenda/public/Index.php';</script>";
            } else {
                echo "<script>alert('Error al registrar.'); history.back();</script>";
            }
        }
    }
}
?>