<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login3.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Hora en Centros de Salud</title>
    <link rel="stylesheet" href="quick-salud.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <!-- Logo del ministerio -->
            <a class="navbar-brand" href="#">
                <img src="logo100.png" alt="Ministerio de Salud" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="quick-salud.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Ultimas-novedades.html">Ultimas Novedades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Reseña</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.html">Contactanos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="FAQ.html">Preguntas Frecuentes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="AgendarHora.php">Agenda tu hora</a>
                    </li>
                </ul>
                <!-- Botón de sesión -->
                <div class="d-flex">
                    <?php if (isset($_SESSION['username'])): ?>
                        <a class="btn btn-outline-light" href="logout.php">Cerrar Sesión</a>
                    <?php else: ?>
                        <a class="btn btn-outline-light" href="login3.html">Iniciar Sesión</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

       <!-- Contenido Principal -->
       <div class="container mt-5 pt-5">
        <h1 class="text-center mt-5">Agendar Hora en Centros de Salud Privados</h1>

        <!-- Filtro de tipo de atención -->
        <div class="row mt-4">
            <div class="col-md-4">
                <label for="filtroTipo" class="form-label">Filtrar por tipo de atención:</label>
                <select id="filtroTipo" class="form-select" onchange="filtrarCentros()">
                    <option value="todos">Todos</option>
                    <option value="publico">Público</option>
                    <option value="privado">Privado</option>
                </select>
            </div>
        </div>

        <!-- Tabla de centros de salud -->
        <div class="row mt-4">
            <div class="col-md-12">
                <table class="table table-bordered" id="tablaCentros">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Atención</th>
                            <th>Tipo</th>
                            <th>Horario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTabla">
                        <!-- Filas se generarán dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Selección de fecha y hora -->
        <div class="row mt-4">
            <div class="col-md-4">
                <label for="fecha" class="form-label">Selecciona Fecha:</label>
                <input type="date" id="fecha" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="hora" class="form-label">Selecciona Hora:</label>
                <input type="time" id="hora" class="form-control">
            </div>
        </div>

        <!-- Botón para agendar -->
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <button class="btn btn-primary" onclick="agendarHora()">Agendar Hora</button>
            </div>
        </div>
    </div>


    </div>
    <script>
        // Función para cargar centros de salud desde el servidor
        function cargarCentros() {
            fetch('obtener_centros2.php')
                .then(response => response.json())
                .then(centros => {
                    const cuerpoTabla = document.getElementById('cuerpoTabla');
                    cuerpoTabla.innerHTML = ''; // Limpiar tabla antes de cargar
    
                    centros.forEach(centro => {
                        let fila = `<tr>
                                        <td>${centro.nombre}</td>
                                        <td>${centro.atencion}</td>
                                        <td>${centro.tipo}</td>
                                        <td>${centro.horario}</td>
                                        <td><button class="btn btn-success" onclick="seleccionarCentro(${centro.id})">Agendar</button></td>
                                    </tr>`;
                        cuerpoTabla.innerHTML += fila;
                    });
                })
                .catch(error => console.error('Error al cargar centros:', error));
        }
    
        document.addEventListener('DOMContentLoaded', cargarCentros);
    </script>

    <script src="agendar.js"></script>


</body>
</html>


