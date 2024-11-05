<?php
require 'conexion.php';

if (isset($_GET['id']) && isset($_GET['tipo'])) {
    $id = (int) $_GET['id'];
    $tipo = $_GET['tipo'];

    // Verificar si el tipo es válido
    if ($tipo === 'reseñas') {
        $query = "DELETE FROM reseñas WHERE id = ?";
    } elseif ($tipo === 'contacto') {
        $query = "DELETE FROM contacto WHERE id = ?";
    } else {
        die("Tipo no válido.");
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Registro eliminado con éxito.'); window.location.href='admin-encuestas.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el registro.'); window.location.href='admin-encuestas.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Datos insuficientes para la eliminación.'); window.location.href='admin-encuestas.php';</script>";
}

$conn->close();
?>
