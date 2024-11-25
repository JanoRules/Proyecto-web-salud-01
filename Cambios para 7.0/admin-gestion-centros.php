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
    // Verificar si el centro supera el 70% de capacidad
    $checkSql = "SELECT capacidad_total, (personas_atencion_baja + personas_atencion_media + personas_atencion_inmediata) AS total_ocupado 
                 FROM centros_salud WHERE id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $capacidad_total = $row['capacidad_total'];
        $total_ocupado = $row['total_ocupado'];

        if ($capacidad_total > 0 && ($total_ocupado / $capacidad_total) >= 0.7) {
            $mensaje = "El centro de salud ID: $id está casi lleno (ocupación: " . round(($total_ocupado / $capacidad_total) * 100) . "%).";
            $notifSql = "INSERT INTO notificaciones (mensaje, visto) VALUES (?, FALSE)";
            $notifStmt = $conn->prepare($notifSql);
            $notifStmt->bind_param("s", $mensaje);
            $notifStmt->execute();
        }
    }
    header("Location: admin-gestion-centros.php"); // Redirigir tras la eliminación
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

    header("Location: admin-gestion-centros.php");
    exit();
}



// Obtener todos los centros de salud
$sql = "SELECT * FROM centros_salud";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Centros de Salud</title>
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
    <!-- Imagen del logo -->
    <div class="logo">
        <img src="logo100.png" alt="Ministerio de Salud" height="100">
    </div>

    <div class="container">
        <h1>Gestión de Centros de Salud</h1>

        <!-- Formulario para agregar un nuevo centro de salud -->
        <h2>Añadir Centro de Salud</h2>
        <form action="admin-gestion-centros.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="lat">Latitud:</label>
            <input type="text" id="lat" name="lat" required>

            <label for="lng">Longitud:</label>
            <input type="text" id="lng" name="lng" required>

            <label for="atencion">Atención:</label>
            <select id="atencion" name="atencion" required>
                <option value="publico">Público</option>
                <option value="privado">Privado</option>
            </select>

            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo" required>
                <option value="hospital">Hospital</option>
                <option value="clinica">Clínica</option>
                <option value="cesfam">Cesfam</option>
                <option value="consultorio">Consultorio</option>
            </select>

            <label for="horario">Horario:</label>
            <input type="text" id="horario" name="horario" required>

            <label for="horario_atencion">Horario de Atención:</label>
            <input type="text" id="horario_atencion" name="horario_atencion">

            <label for="capacidad_total">Capacidad Total:</label>
            <input type="number" id="capacidad_total" name="capacidad_total">

            <label for="personas_baja">Personas Atención Baja:</label>
            <input type="number" id="personas_baja" name="personas_baja">

            <label for="personas_media">Personas Atención Media:</label>
            <input type="number" id="personas_media" name="personas_media">

            <label for="personas_inmediata">Personas Atención Inmediata:</label>
            <input type="number" id="personas_inmediata" name="personas_inmediata">

            <button type="submit" name="addCenter">Añadir Centro</button>
        </form>

        <!-- Tabla de centros de salud existentes -->
        <h2>Centros de Salud Existentes</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Atención</th>
                <th>Tipo</th>
                <th>Capacidad Total</th>
                <th>Baja</th>
                <th>Media</th>
                <th>Inmediata</th>
                <th>Acciones</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['atencion']; ?></td>
                    <td><?php echo $row['tipo']; ?></td>
                    <td><?php echo $row['capacidad_total']; ?></td>
                    <td><?php echo $row['personas_atencion_baja']; ?></td>
                    <td><?php echo $row['personas_atencion_media']; ?></td>
                    <td><?php echo $row['personas_atencion_inmediata']; ?></td>
                    <td>
                        <!-- Formulario para editar la capacidad de atención -->
                        <form action="admin-gestion-centros.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="number" name="personas_baja" value="<?php echo $row['personas_atencion_baja']; ?>" required>
                            <input type="number" name="personas_media" value="<?php echo $row['personas_atencion_media']; ?>" required>
                            <input type="number" name="personas_inmediata" value="<?php echo $row['personas_atencion_inmediata']; ?>" required>
                            <button type="submit" name="updateCenter">Actualizar</button>
                        </form>
                        <a href="admin-gestion-centros.php?delete=<?php echo $row['id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>


