<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Mi Agenda</title>
    <link rel="stylesheet" href="/Agenda/public/style.css">
</head>
<body class="pagina-login">
    <div class="contenedor-login">
        <div class="seccion-login">
            <div class="bloque-izquierdo">
                <div class="marca-app">
                    <h1>Mi Agenda</h1>
                </div>
                <p class="descripcion-app">Únete a miles de usuarios que organizan su tiempo de manera efectiva</p>
                <div class="caracteristicas">
                    <div class="caracteristica-item">
                        <span>Comienza en segundos</span>
                    </div>
                    <div class="caracteristica-item">
                        <span>Totalmente seguro</span>
                    </div>
                    <div class="caracteristica-item">
                        <span>Rápido y eficiente</span>
                    </div>
                </div>
            </div>

            <div class="bloque-derecho">
                <form action="/Agenda/public/Index.php?accion=guardar_usuario" method="POST" class="formulario-login" autocomplete="off">
                    <div class="encabezado-formulario">
                        <h2>Crear cuenta</h2>
                        <p>Únete a Mi Agenda ahora</p>
                    </div>

                    <div class="fila-campos">
                        <div class="campo-entrada">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required>
                            <span class="linea-foco"></span>
                        </div>
                        <div class="campo-entrada">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" id="apellidos" name="apellidos" placeholder="Tus apellidos" required>
                            <span class="linea-foco"></span>
                        </div>
                    </div>

                    <div class="campo-entrada">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" id="correo" name="correo" placeholder="correo@ejemplo.com" required>
                        <span class="linea-foco"></span>
                    </div>

                    <div class="campo-entrada">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" placeholder="123456789" required pattern="[0-9]{9}" title="Debe contener 9 dígitos">
                        <span class="linea-foco"></span>
                    </div>

                    <div class="campo-entrada">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="new-password">
                        <span class="linea-foco"></span>
                    </div>

                    <button type="submit" class="boton-enviar">Crear mi Cuenta</button>

                    <div class="divisor-registro">
                        <span>¿Ya tienes cuenta?</span>
                    </div>

                    <a href="/Agenda/public/Index.php" class="enlace-registro">Volver al inicio de sesión</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.campo-entrada input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('activo');
            });
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('activo');
                }
            });
        });
    </script>
</body>
</html>