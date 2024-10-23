<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login2.html"); // Redirige a login si no es administrador
    exit();
}

include 'conexion.php'; // Conexión a la base de datos

// Eliminar usuario
if (isset($_GET['delete'])) {
    $userId = $_GET['delete'];
    $deleteSql = "DELETE FROM login WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    header("Location: admin_dashboard.php"); // Redirigir tras la eliminación
    exit();
}

// Obtener todos los usuarios
$sql = "SELECT id, username, rut FROM login WHERE role = 'user'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <h1>Panel de Administración</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre de Usuario</th>
            <th>RUT</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['rut']; ?></td>
                <td><a href="admin_dashboard.php?delete=<?php echo $row['id']; ?>">Eliminar</a></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
