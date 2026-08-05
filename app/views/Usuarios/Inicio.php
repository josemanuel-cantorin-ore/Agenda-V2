<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../auth/Login.php");
    exit();
}

require_once '../../models/Tareas.php';
$modeloTarea = new Tarea();
$listaTareas = $modeloTarea->obtenerTareasPorUsuario($_SESSION['id_usuario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Agenda - Dashboard</title>
    <link rel="stylesheet" href="/Agenda/public/style.css">
</head>
<body class="pagina-dashboard">
    <aside class="barra-lateral">
        <div class="logo-dashboard">
            <span class="icono"></span>
            <h1>Agenda</h1>
        </div>
        
        <nav class="navegacion">
            <a href="/Agenda/public/Index.php?accion=inicio" class="enlace-nav activo">
                <span>Mis Tareas</span>
            </a>
            <a href="/Agenda/public/Index.php?accion=eventos" class="enlace-nav">
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
                <h2>Mis Tareas</h2>
                <p>Organiza y gestiona tus actividades pendientes</p>
            </div>
            <button class="boton-crear" onclick="abrirModal()">
                <span>+</span> Nueva Tarea
            </button>
        </div>

        <div class="contenedor-tareas">
            <?php if (count($listaTareas) > 0): ?>
                <?php foreach ($listaTareas as $tarea): ?>
                    <div class="tarjeta-tarea prioridad-<?php echo htmlspecialchars($tarea->prioridad); ?>">
                        <div class="cabecera-tarea">
                            <div class="insignias">
                                <span class="insignia estado-<?php echo str_replace(' ', '-', $tarea->estado_tarea); ?>">
                                    <?php echo ucfirst(htmlspecialchars($tarea->estado_tarea)); ?>
                                </span>
                                <span class="insignia insignia-prioridad"><?php echo ucfirst(htmlspecialchars($tarea->prioridad)); ?></span>
                            </div>
                            <div class="botones-accion">
                                <button class="btn-accion" title="Editar"
                                    data-id="<?php echo $tarea->id_tp; ?>"
                                    data-nombre="<?php echo htmlspecialchars($tarea->nombre_tarea); ?>"
                                    data-contenido="<?php echo htmlspecialchars($tarea->contenido_tarea); ?>"
                                    data-estado="<?php echo $tarea->estado_tarea; ?>"
                                    data-prioridad="<?php echo $tarea->prioridad; ?>"
                                    data-fecha="<?php echo $tarea->fecha_limite ? date("Y-m-d\TH:i", strtotime($tarea->fecha_limite)) : ''; ?>"
                                    onclick="abrirModal(this)">
                                    Editar
                                </button>
                                <button class="btn-accion btn-peligro" title="Eliminar" onclick="confirmarEliminar(<?php echo $tarea->id_tp; ?>)">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                        <h3 class="titulo-tarea"><?php echo htmlspecialchars($tarea->nombre_tarea); ?></h3>
                        <p class="descripcion-tarea"><?php echo htmlspecialchars($tarea->contenido_tarea); ?></p>
                        <div class="pie-tarea">
                            <span class="fecha-limite">
                                Fecha limite: <?php echo $tarea->fecha_limite ? date("d/m/Y H:i", strtotime($tarea->fecha_limite)) : 'Sin fecha'; ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="estado-vacio">
                    <h3>Sin tareas pendientes</h3>
                    <p>Excelente, has completado todas tus tareas. Crea una nueva.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <div id="modalForm" class="modal-overlay">
        <div class="modal-ventana">
            <div class="modal-cabecera">
                <h2 id="modalTitle">Nueva Tarea</h2>
                <button class="btn-cerrar" onclick="cerrarModal()">&times;</button>
            </div>
            
            <form action="/Agenda/public/Index.php?accion=guardar_tarea" method="POST" class="formulario-modal">
                <input type="hidden" id="id_tp" name="id_tp" value="">
                
                <div class="grupo-formulario">
                    <label for="nombre_tarea">Título de la Tarea</label>
                    <input type="text" id="nombre_tarea" name="nombre_tarea" required placeholder="Escribe el título de tu tarea">
                </div>
                
                <div class="grupo-formulario">
                    <label for="contenido_tarea">Descripción</label>
                    <textarea id="contenido_tarea" name="contenido_tarea" rows="3" placeholder="Añade detalles sobre esta tarea..."></textarea>
                </div>

                <div class="fila-formulario">
                    <div class="grupo-formulario">
                        <label for="estado_tarea">Estado</label>
                        <select id="estado_tarea" name="estado_tarea">
                            <option value="pendiente">Pendiente</option>
                            <option value="en proceso">En Proceso</option>
                            <option value="completada">Completada</option>
                        </select>
                    </div>
                    <div class="grupo-formulario">
                        <label for="prioridad">Prioridad</label>
                        <select id="prioridad" name="prioridad">
                            <option value="baja">Baja</option>
                            <option value="media">Media</option>
                            <option value="alta">Alta</option>
                        </select>
                    </div>
                </div>

                <div class="grupo-formulario">
                    <label for="fecha_limite">Fecha y Hora Límite</label>
                    <input type="datetime-local" id="fecha_limite" name="fecha_limite">
                </div>

                <div class="pie-modal">
                    <button type="button" class="boton-secundario" onclick="cerrarModal()">Cancelar</button>
                    <button type="submit" class="boton-primario">Guardar Tarea</button>
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
                titulo.innerText = "Editar Tarea";
                document.getElementById('id_tp').value = boton.getAttribute('data-id');
                document.getElementById('nombre_tarea').value = boton.getAttribute('data-nombre');
                document.getElementById('contenido_tarea').value = boton.getAttribute('data-contenido');
                document.getElementById('estado_tarea').value = boton.getAttribute('data-estado');
                document.getElementById('prioridad').value = boton.getAttribute('data-prioridad');
                document.getElementById('fecha_limite').value = boton.getAttribute('data-fecha');
            } else {
                titulo.innerText = "Nueva Tarea";
                document.getElementById('id_tp').value = "";
                document.getElementById('nombre_tarea').value = "";
                document.getElementById('contenido_tarea').value = "";
                document.getElementById('estado_tarea').value = "pendiente";
                document.getElementById('prioridad').value = "media";
                document.getElementById('fecha_limite').value = "";
            }
            modal.style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modalForm').style.display = 'none';
        }

        function confirmarEliminar(id) {
            if (confirm("¿Estás completamente seguro de eliminar esta tarea? Esta acción no se puede deshacer.")) {
                window.location.href = `/Agenda/public/Index.php?accion=eliminar_tarea&id=${id}`;
            }
        }

        // Cerrar modal al hacer click fuera
        document.getElementById('modalForm').addEventListener('click', function(e) {
            if (e.target === this) cerrarModal();
        });
    </script>
</body>
</html>
