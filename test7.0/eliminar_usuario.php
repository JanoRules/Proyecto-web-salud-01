<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el usuario de la base de datos
    $sql = "DELETE FROM login WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.html"); // Redirigir de vuelta al panel de administración
    } else {
        echo "Error al eliminar el usuario.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID de usuario no proporcionado.";
}
?>
