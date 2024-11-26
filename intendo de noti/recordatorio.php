<?php
include 'conexion.php';

$query = "SELECT * FROM citas WHERE recordatorio_enviado = 0 AND fecha_hora <= NOW() + INTERVAL 1 HOUR";
$result = mysqli_query($conexion, $query);

while ($row = mysqli_fetch_assoc($result)) {
    // Enviar recordatorio por correo o notificación
    mail($row['email'], "Recordatorio de cita", "Tienes una cita programada: " . $row['descripcion']);
    
    // Marcar como enviado
    $update_query = "UPDATE citas SET recordatorio_enviado = 1 WHERE id = " . $row['id'];
    mysqli_query($conexion, $update_query);
}
?>
