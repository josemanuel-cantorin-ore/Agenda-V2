<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../auth/Login.php");
    exit();
}

require_once '../../models/Eventos.php';
$modeloEvento = new Evento();
$listaEventos = $modeloEvento->obtenerEventosPorUsuario($_SESSION['id_usuario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Eventos - Mi Agenda</title>
    <link rel="stylesheet" href="/Agenda/public/style.css">
</head>
<body class="pagina-dashboard">
    <aside class="barra-lateral">
        <div class="logo-dashboard">
            <span class="icono"></span>
            <h1>Agenda</h1>
        </div>
        
        <nav class="navegacion">
            <a href="/Agenda/public/Index.php?accion=inicio" class="enlace-nav">
                <span>Mis Tareas</span>
            </a>
            <a href="/Agenda/public/Index.php?accion=eventos" class="enlace-nav activo">
                <span>Eventos</span>
            </a>
        </nav>

        <div class="seccion-usuario">
            <div class="tarjeta-usuario">
                <div class="avatar-usuario"><?php echo strtoupper(substr($_SESSION['nombre_usuario'], 0, 1)); ?></div>
                <div class="info-usuario">
                    <p class="nombre-usuario"><?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></p>
                    <small>Conectado</small>
                </div>
            </div>
            <a href="/Agenda/public/Index.php?accion=logout" class="boton-salida" onclick="return confirm('¿Deseas cerrar sesión?');">
                Cerrar Sesión
            </a>
        </div>
    </aside>

    <main class="area-principal">
        <div class="encabezado-dashboard">
            <div class="titulo-seccion">
                <h2>Mis Eventos</h2>
                <p>Gestiona tu calendario y eventos próximos</p>
            </div>
            <button class="boton-crear" onclick="abrirModal()">
                <span>+</span> Nuevo Evento
            </button>
        </div>

        <div class="contenedor-tareas">
            <?php if (count($listaEventos) > 0): ?>
                <?php foreach ($listaEventos as $evento): ?>
                    <div class="tarjeta-evento">
                        <div class="cabecera-tarea">
                            <div class="insignias">
                                <span class="insignia insignia-evento">
                                    <?php echo $evento->repeticion ? ucfirst(htmlspecialchars($evento->repeticion)) : 'Único'; ?>
                                </span>
                            </div>
                            <div class="botones-accion">
                                <button class="btn-accion" title="Editar"
                                    data-id="<?php echo $evento->id_evento; ?>"
                                    data-titulo="<?php echo htmlspecialchars($evento->titulo_evento); ?>"
                                    data-contenido="<?php echo htmlspecialchars($evento->contenido_evento); ?>"
                                    data-fecha="<?php echo date('Y-m-d\TH:i', strtotime($evento->fecha)); ?>"
                                    data-fechafin="<?php echo $evento->fecha_finalizacion ? date('Y-m-d\TH:i', strtotime($evento->fecha_finalizacion)) : ''; ?>"
                                    data-ubicacion="<?php echo htmlspecialchars($evento->ubicacion); ?>"
                                    data-repeticion="<?php echo $evento->repeticion; ?>"
                                    onclick="abrirModal(this)">
                                    Editar
                                </button>
                                <button class="btn-accion btn-peligro" title="Eliminar" onclick="confirmarEliminar(<?php echo $evento->id_evento; ?>)">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                        <h3 class="titulo-tarea"><?php echo htmlspecialchars($evento->titulo_evento); ?></h3>
                        <p class="descripcion-tarea"><?php echo htmlspecialchars($evento->contenido_evento); ?></p>
                        
                        <?php if($evento->ubicacion): ?>
                            <p class="ubicacion-evento">
                                <?php echo htmlspecialchars($evento->ubicacion); ?>
                            </p>
                        <?php endif; ?>

                        <div class="detalles-evento">
                            <div class="detalle">
                                <span class="etiqueta">Inicio:</span>
                                <span><?php echo date("d/m/Y H:i", strtotime($evento->fecha)); ?></span>
                            </div>
                            <?php if($evento->fecha_finalizacion): ?>
                                <div class="detalle">
                                    <span class="etiqueta">Fin:</span>
                                    <span><?php echo date("d/m/Y H:i", strtotime($evento->fecha_finalizacion)); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="estado-vacio">
                    <h3>Tu calendario está vacío</h3>
                    <p>Crea un nuevo evento para empezar a organizar tus actividades.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <div id="modalForm" class="modal-overlay">
        <div class="modal-ventana">
            <div class="modal-cabecera">
                <h2 id="modalTitle">Nuevo Evento</h2>
                <button class="btn-cerrar" onclick="cerrarModal()">&times;</button>
            </div>
            
            <form action="/Agenda/public/Index.php?accion=guardar_evento" method="POST" class="formulario-modal">
                <input type="hidden" id="id_evento" name="id_evento" value="">
                
                <div class="grupo-formulario">
                    <label for="titulo_evento">Título del Evento</label>
                    <input type="text" id="titulo_evento" name="titulo_evento" required placeholder="Nombre del evento">
                </div>
                
                <div class="grupo-formulario">
                    <label for="contenido_evento">Descripción</label>
                    <textarea id="contenido_evento" name="contenido_evento" rows="2" placeholder="Detalles del evento..."></textarea>
                </div>

                <div class="fila-formulario">
                    <div class="grupo-formulario">
                        <label for="fecha">Fecha de Inicio</label>
                        <input type="datetime-local" id="fecha" name="fecha" required>
                    </div>
                    <div class="grupo-formulario">
                        <label for="fecha_finalizacion">Fecha de Fin</label>
                        <input type="datetime-local" id="fecha_finalizacion" name="fecha_finalizacion">
                    </div>
                </div>

                <div class="fila-formulario">
                    <div class="grupo-formulario">
                        <label for="ubicacion">Ubicación</label>
                        <input type="text" id="ubicacion" name="ubicacion" placeholder="Lugar del evento (opcional)">
                    </div>
                    <div class="grupo-formulario">
                        <label for="repeticion">Repetición</label>
                        <select id="repeticion" name="repeticion">
                            <option value="">Sin repetición</option>
                            <option value="diario">Diario</option>
                            <option value="semanal">Semanal</option>
                            <option value="mensual">Mensual</option>
                        </select>
                    </div>
                </div>

                <div class="pie-modal">
                    <button type="button" class="boton-secundario" onclick="cerrarModal()">Cancelar</button>
                    <button type="submit" class="boton-primario">Guardar Evento</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        window.onpageshow = function(event) { 
            if (event.persisted) window.location.reload(); 
        };

        function abrirModal(boton = null) {
            const modal = document.getElementById('modalForm');
            const titulo = document.getElementById('modalTitle');
            
            if (boton) {
                titulo.innerText = "Editar Evento";
                document.getElementById('id_evento').value = boton.getAttribute('data-id');
                document.getElementById('titulo_evento').value = boton.getAttribute('data-titulo');
                document.getElementById('contenido_evento').value = boton.getAttribute('data-contenido');
                document.getElementById('fecha').value = boton.getAttribute('data-fecha');
                document.getElementById('fecha_finalizacion').value = boton.getAttribute('data-fechafin');
                document.getElementById('ubicacion').value = boton.getAttribute('data-ubicacion');
                document.getElementById('repeticion').value = boton.getAttribute('data-repeticion') || '';
            } else {
                titulo.innerText = "Nuevo Evento";
                document.getElementById('id_evento').value = "";
                document.getElementById('titulo_evento').value = "";
                document.getElementById('contenido_evento').value = "";
                document.getElementById('fecha').value = "";
                document.getElementById('fecha_finalizacion').value = "";
                document.getElementById('ubicacion').value = "";
                document.getElementById('repeticion').value = "";
            }
            modal.style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modalForm').style.display = 'none';
        }

        function confirmarEliminar(id) {
            if (confirm("¿Estás seguro de eliminar este evento?")) {
                window.location.href = `/Agenda/public/Index.php?accion=eliminar_evento&id=${id}`;
            }
        }

        document.getElementById('modalForm').addEventListener('click', function(e) {
            if (e.target === this) cerrarModal();
        });
    </script>
</body>
</html>
