<?php
session_start();
include 'conexion.php'; // Asegúrate de que estás conectado a la base de datos

$sql = "SELECT * FROM centros_salud"; // Consulta para obtener los centros de salud
$result = $conexion->query($sql);

while ($centro = $result->fetch_assoc()) {
    echo "<div>{$centro['nombre']} - {$centro['direccion']}</div>";
    echo "<button onclick='marcarFavorito({$centro['id']})'>Marcar como Favorito</button>"; // Botón para marcar como favorito
}
?>
