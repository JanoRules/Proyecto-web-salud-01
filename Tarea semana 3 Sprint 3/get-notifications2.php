<?php
include 'conexion.php';

// Consultar notificaciones no vistas
$sql = "SELECT id, mensaje FROM notificaciones WHERE visto = FALSE";
$result = $conn->query($sql);

$notificaciones2 = [];
while ($row = $result->fetch_assoc()) {
    $notificaciones2[] = $row;
}

// Marcar como vistas las notificaciones enviadas
if (!empty($notificaciones2)) {
    $ids2 = array_column($notificaciones2, 'id');
    $idList2 = implode(',', $ids2);
    $updateSql2 = "UPDATE notificaciones SET visto = TRUE WHERE id IN ($idList2)";
    $conn->query($updateSql2);
}

// Enviar las notificaciones en formato JSON
header('Content-Type: application/json');
echo json_encode($notificaciones2);
?>
