<?php
include 'conexion.php';
session_start();

$userId = $_SESSION['user_id'];
$sql = "SELECT c.nombre, c.direccion FROM favoritos f JOIN centros_salud c ON f.centro_id = c.id WHERE f.user_id = '$userId'";
$result = $conn->query($sql);

echo "<h2>Tus Centros Favoritos</h2>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div>{$row['nombre']} - {$row['direccion']}</div>";
    }
} else {
    echo "<p>No tienes centros favoritos.</p>";
}

$conn->close();
?>
