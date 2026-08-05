<?php
require_once __DIR__ . '/../models/Usuarios.php';
class AuthController {
    public function procesarLogin(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $user = trim($_POST['usuario']);
            $password = trim($_POST['password']);
            $modelUsuario = new Usuario();
            $usuario = $modelUsuario->buscarPorUsuario($user);
            if ($usuario && (password_verify($password, $usuario->contrasena) || $password === $usuario->contrasena)) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['id_usuario'] = $usuario->id_usuario;
                $_SESSION['nombre_usuario'] = $usuario->nombre_usuario;
                $_SESSION['apellidos'] = $usuario->apellidos;
                $_SESSION['numero_telefono'] = $usuario->numero_telefono;

                echo "<script>
                        window.location.href = '/Agenda/app/views/usuarios/Inicio.php';
                      </script>";
                exit();
            } else {
                echo "<script>
                        alert('Error: Usuario o contraseña incorrectos.');
                        window.location.href = '/Agenda/app/views/auth/Login.php';
                      </script>";
                exit();
            }
        } else {
            header("Location: /Agenda/app/views/auth/Login.php");
            exit();
        }
    }
} 
?>