<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_POST['usuario_id'];
    $fecha_hora = $_POST['fecha_hora'];
    $descripcion = $_POST['descripcion'];

    $query = "INSERT INTO citas (usuario_id, fecha_hora, descripcion) VALUES ('$usuario_id', '$fecha_hora', '$descripcion')";
    if (mysqli_query($conexion, $query)) {
        echo "Cita agendada con éxito.";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>
