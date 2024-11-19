<?php
include 'conexion.php'; // Incluir archivo de conexión a la base de datos

// Verificar si el administrador quiere eliminar un usuario
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    // Consulta para eliminar al usuario por ID
    $sql = "DELETE FROM login WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<p>Usuario eliminado exitosamente.</p>";
    } else {
        echo "<p>Error al eliminar usuario.</p>";
    }
}

// Verificar si el administrador quiere enviar un mensaje
if (isset($_POST['send_message'])) {
    $user_id = $_POST['user_id'];
    $mensaje = $_POST['mensaje'];

    // Validar que el mensaje no esté vacío
    if (!empty($mensaje)) {
        // Consulta para insertar el mensaje en la tabla `mensajes`
        $sql = "INSERT INTO mensajes (id_usuario, mensaje) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $mensaje);

        if ($stmt->execute()) {
            echo "<p>Mensaje enviado exitosamente.</p>";
        } else {
            echo "<p>Error al enviar el mensaje.</p>";
        }
    } else {
        echo "<p>El mensaje no puede estar vacío.</p>";
    }
}

// Mostrar todos los usuarios de la base de datos
$sql = "SELECT id, username, role FROM login";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <style>
        body {
            background-color: #0c0b34;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2 {
            color: #ffffff;
        }
        form {
            background-color: #1a1a40;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        label {
            display: block;
            margin-top: 10px;
            text-align: left;
        }
        input, textarea, button {
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
        .logo {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Imagen del logo -->
        <div class="logo">
            <img src="logo100.png" alt="Ministerio de Salud" height="100">
        </div>

        <h1>Gestión de Usuarios</h1>

        <?php
        if ($result->num_rows > 0) {
            echo "<h2>Lista de Usuarios</h2>";
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de Usuario</th>
                        <th>Rol</th>
                        <th>Eliminar Usuario</th>
                        <th>Mensaje</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['username'] . "</td>
                        <td>" . $row['role'] . "</td>
                        <td>
                            <!-- Formulario para eliminar usuario -->
                            <form method='POST' style='display:inline-block;'>
                                <input type='hidden' name='user_id' value='" . $row['id'] . "'>
                                <button type='submit' name='delete_user'>Eliminar</button>
                            </form>
                        </td>
                        <td>
                            <!-- Formulario para enviar mensaje -->
                            <form method='POST' style='display:inline-block;'>
                                <input type='hidden' name='user_id' value='" . $row['id'] . "'>
                                <textarea name='mensaje' placeholder='Escribe tu mensaje...' required></textarea>
                                <button type='submit' name='send_message'>Enviar Mensaje</button>
                            </form>
                        </td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No se encontraron usuarios.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
