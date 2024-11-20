<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Feedback</title>
    <link rel="stylesheet" href="administracion.css">
    <style>
        /* Estilos para tablas y botones */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        tr:nth-child(even) { background-color: #3377FF; }
        tr:hover { background-color: #BBA9BB; }
        h2 { margin-top: 20px; color: #333; font-size: 24px; }
        .btn { background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin: 10px; }
        .btn:hover { background-color: #0056b3; }
        .container { max-width: 800px; margin: auto; padding: 20px; text-align: center; }
        .logo img { height: 100px; }
    </style>
    
    <script>
        // Función para mostrar u ocultar secciones según el botón seleccionado
        function mostrarSeccion(seccion) {
            document.getElementById("seccion-resenas").style.display = 'none';
            document.getElementById("seccion-contacto").style.display = 'none';

            if (seccion === 'resenas') {
                document.getElementById("seccion-resenas").style.display = 'block';
            } else if (seccion === 'contacto') {
                document.getElementById("seccion-contacto").style.display = 'block';
            }
        }
        
        // Confirmación antes de eliminar
        function confirmarEliminacion(id, tipo) {
            if (confirm("¿Estás seguro de que quieres eliminar este registro?")) {
                window.location.href = `eliminar_feedback.php?id=${id}&tipo=${tipo}`;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="logo100.png" alt="Ministerio de Salud">
        </div>
        
        <h1>Gestión de Feedback</h1>
        
        <!-- Botones para seleccionar la vista -->
        <button onclick="mostrarSeccion('resenas')" class="btn">Ver Reseñas de Usuarios</button>
        <button onclick="mostrarSeccion('contacto')" class="btn">Ver Mensajes de Contacto</button>

        <!-- Sección para ver reseñas de usuarios -->
        <div id="seccion-resenas" style="display: none;">
            <h2>Reseñas de Usuarios</h2>
            <div id="lista-resenas">
                <?php
                require 'conexion.php';

                // Consulta para obtener las reseñas
                $queryResenas = "SELECT id, nombre, centro_salud_id, calificacion, reseña FROM reseñas";
                $resultResenas = $conn->query($queryResenas);
                
                if ($resultResenas && $resultResenas->num_rows > 0) {
                    echo "<table><tr><th>Nombre</th><th>Centro de Salud</th><th>Calificación</th><th>Reseña</th><th>Acciones</th></tr>";
                    while ($row = $resultResenas->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["nombre"]) . "</td>
                                <td>" . htmlspecialchars($row["centro_salud_id"]) . "</td>
                                <td>" . htmlspecialchars($row["calificacion"]) . "</td>
                                <td>" . htmlspecialchars($row["reseña"]) . "</td>
                                <td><button class='btn' onclick='confirmarEliminacion(" . $row["id"] . ", \"reseñas\")'>Eliminar</button></td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No hay reseñas disponibles.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Sección para ver mensajes de contacto -->
        <div id="seccion-contacto" style="display: none;">
            <h2>Mensajes de Contacto</h2>
            <div id="lista-contacto">
                <?php
                // Consulta para obtener los mensajes de contacto
                $queryContacto = "SELECT id, tipo_queja, region, descripcion, fecha FROM contacto";
                $resultContacto = $conn->query($queryContacto);
                
                if ($resultContacto && $resultContacto->num_rows > 0) {
                    echo "<table><tr><th>Tipo de Queja</th><th>Región</th><th>Descripción</th><th>Fecha</th><th>Acciones</th></tr>";
                    while ($row = $resultContacto->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["tipo_queja"]) . "</td>
                                <td>" . htmlspecialchars($row["region"]) . "</td>
                                <td>" . htmlspecialchars($row["descripcion"]) . "</td>
                                <td>" . htmlspecialchars($row["fecha"]) . "</td>
                                <td><button class='btn' onclick='confirmarEliminacion(" . $row["id"] . ", \"contacto\")'>Eliminar</button></td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No hay mensajes de contacto disponibles.</p>";
                }
                ?>
            </div>
        </div>
        
        <!-- Botón de inicio -->
        <div>
            <a href="quick-salud.html" class="btn">Inicio</a>
        </div>
    </div>
</body>
</html>
