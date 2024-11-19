<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
    header("Location: login2.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes Recibidos - Quick Salud</title>
    <link rel="stylesheet" href="update-user.css">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: #f0f2f5;
            margin-top: 60px; /* Ajuste para navbar fija */
        }
        h3 {
            margin-bottom: 20px;
        }
        #mensajes-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .mensaje {
            border-bottom: 1px solid #e6e6e6;
            padding: 10px 0;
        }
        .mensaje:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="logo100.png" alt="Ministerio de Salud" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="dashboard.html">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="AgendarHora.php">Agendar Hora</a></li>
                </ul>
                <div class="d-flex">
                    <a class="btn btn-outline-light me-2" href="dashboard.html">Usuario</a>
                    <a class="btn btn-outline-light" href="logout.php">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h3>Mensajes Recibidos</h3>
        <div id="mensajes-container">
            <p>Cargando mensajes...</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('obtener-mensajes.php')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('mensajes-container');
                    container.innerHTML = ''; // Limpiar contenido

                    if (data.success && data.mensajes.length > 0) {
                        data.mensajes.forEach(msg => {
                            const mensajeDiv = document.createElement('div');
                            mensajeDiv.classList.add('mensaje');
                            mensajeDiv.innerHTML = `
                                <strong>Fecha:</strong> ${msg.fecha_envio} <br>
                                <strong>Mensaje:</strong> ${msg.mensaje}
                            `;
                            container.appendChild(mensajeDiv);
                        });
                    } else {
                        container.innerHTML = '<p>No tienes mensajes nuevos.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error al cargar los mensajes:', error);
                    document.getElementById('mensajes-container').innerHTML = '<p>Error al cargar los mensajes.</p>';
                });
        });
    </script>

</body>
</html>
