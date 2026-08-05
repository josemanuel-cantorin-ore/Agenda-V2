<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceder - Mi Agenda</title>
    <link rel="stylesheet" href="/Agenda/public/style.css">
</head>
<body class="pagina-login">
    <div class="contenedor-login">
        <div class="seccion-login">
            <div class="bloque-izquierdo">
                <div class="marca-app">
                    <h1>Mi Agenda</h1>
                </div>
                <p class="descripcion-app">Tu espacio personal para organizar tareas, eventos y optimizar tu tiempo</p>
                <div class="caracteristicas">
                    <div class="caracteristica-item">
                        <span>Gestión de tareas eficiente</span>
                    </div>
                    <div class="caracteristica-item">
                        <span>Calendario de eventos integrado</span>
                    </div>
                    <div class="caracteristica-item">
                        <span>Seguimiento en tiempo real</span>
                    </div>
                </div>
            </div>

            <div class="bloque-derecho">
                <form action="/Agenda/public/Index.php?accion=login" method="POST" class="formulario-login" id="formLogin">
                    <div class="encabezado-formulario">
                        <h2>Inicia sesión</h2>
                        <p>Accede a tu agenda personal</p>
                    </div>

                    <div class="campo-entrada">
                        <label for="usuario">Nombre de usuario</label>
                        <input type="text" id="usuario" name="usuario" placeholder="tu_usuario" required autocomplete="off">
                        <span class="linea-foco"></span>
                    </div>

                    <div class="campo-entrada">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="new-password">
                        <span class="linea-foco"></span>
                    </div>

                    <button type="submit" class="boton-enviar">Acceder</button>

                    <div class="divisor-registro">
                        <span>¿Primera vez aquí?</span>
                    </div>

                    <a href="/Agenda/public/Index.php?accion=registro" class="enlace-registro">Crear una nueva cuenta</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            document.getElementById("formLogin").reset();
        };

        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        };

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