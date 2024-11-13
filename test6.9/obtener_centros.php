<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "base_datos";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conn->connect_error]));
}

// Consulta para obtener los centros de salud
$sql = "SELECT nombre, lat, lng, atencion, tipo, horario, capacidad_total, personas_atencion_baja, personas_atencion_media, personas_atencion_inmediata FROM centros_salud";
$result = $conn->query($sql);

$centros = [];

// Verificar si la consulta devolvió resultados
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $centros[] = $row;
    }
} else {
    // Manejar error en la consulta
    die(json_encode(["error" => "Error en la consulta: " . $conn->error]));
}

// Devolver los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($centros);

// Cerrar la conexión a la base de datos
$conn->close();
?>