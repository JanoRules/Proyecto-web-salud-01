<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login2.html"); // Redirige al login si no es administrador
    exit();
}

include 'conexion.php'; // Conexión a la base de datos

// Manejar la eliminación de un centro de salud
if (isset($_GET['delete'])) {
    $centerId = $_GET['delete'];
    $deleteSql = "DELETE FROM centros_salud WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $centerId);
    $stmt->execute();
    header("Location: admin-visualizar-centro.php"); // Redirigir tras la eliminación
    exit();
}

// Al actualizar el centro, agregamos una notificación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateCenter'])) {
    $id = $_POST['id'];
    $personas_baja = $_POST['personas_baja'];
    $personas_media = $_POST['personas_media'];
    $personas_inmediata = $_POST['personas_inmediata'];

    $updateSql = "UPDATE centros_salud SET personas_atencion_baja = ?, personas_atencion_media = ?, personas_atencion_inmediata = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("iiii", $personas_baja, $personas_media, $personas_inmediata, $id);
    $stmt->execute();

    // Agregar notificación a la base de datos
    $mensaje = "Actualización en centro de salud ID: $id";
    $notifSql = "INSERT INTO notificaciones (mensaje, visto) VALUES (?, FALSE)";
    $notifStmt = $conn->prepare($notifSql);
    $notifStmt->bind_param("s", $mensaje);
    $notifStmt->execute();

    header("Location: admin-visualizar-centro.php");
    exit();
}

// Obtener todos los centros de salud, con el cálculo de personas totales y porcentaje de ocupación
$sql = "SELECT id, nombre, atencion, tipo, capacidad_total, personas_atencion_baja, 
               personas_atencion_media, personas_atencion_inmediata,
               (personas_atencion_baja + personas_atencion_media + personas_atencion_inmediata) AS total_personas,
               ((personas_atencion_baja + personas_atencion_media + personas_atencion_inmediata) / capacidad_total) * 100 AS porcentaje_ocupacion
        FROM centros_salud
        ORDER BY porcentaje_ocupacion DESC"; // Ordenar por total de personas en el centro
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Centros de Salud</title>
    <style>
        body {
            background-color: #0c0b34; /* Color de fondo */
            color: white; /* Color del texto */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center; /* Centramos el contenido */
            min-height: 100vh; /* Asegura que el cuerpo cubra toda la pantalla */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Centrar el contenido verticalmente */
            align-items: center; /* Centrar el contenido horizontalmente */
        }

        /* Espaciado superior al logo */
        .logo {
            margin-bottom: 20px;
            margin-top: 1vh; /* Margen superior para ajustarse a la altura de la ventana */
        }

        /* Contenedor para mantener el contenido centrado */
        .container {
            max-width: 800px;
            width: 100%; /* Asegurar que sea responsivo */
            margin: 0 auto;
            padding: 20px;
        }

        /* Estilos para el formulario */
        form {
            background-color: #1a1a40;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        /* Resto de los estilos existentes */
        h1, h2 {
            color: #ffffff;
        }

        label {
            display: block;
            margin-top: 10px;
            text-align: left;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
        }

        button {
            background-color: #ff5733;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #ff8d68;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid white;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Ver Centros de Salud</h1>

        <!-- Tabla de centros de salud existentes -->
        <h2>Datos capacidad de Centros de Salud</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Atención</th>
                <th>Tipo</th>
                <th>Capacidad Total</th>
                <th>Total Personas</th>
                <th>Porcentaje de Ocupación</th>

            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['atencion']; ?></td>
                    <td><?php echo $row['tipo']; ?></td>
                    <td><?php echo $row['capacidad_total']; ?></td>
                    <td><?php echo $row['total_personas']; ?></td>
                    <td><?php echo round($row['porcentaje_ocupacion'], 2) . "%"; ?></td>

                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>