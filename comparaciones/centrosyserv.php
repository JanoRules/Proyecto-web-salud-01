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
$sql = "
    SELECT cs.nombre, cs.lat, cs.lng, cs.atencion, cs.tipo, cs.horario, cs.capacidad_total, 
           cs.personas_atencion_baja, cs.personas_atencion_media, cs.personas_atencion_inmediata, 
           GROUP_CONCAT(s.nombre) AS servicios
    FROM centros_salud cs
    LEFT JOIN centros_salud_servicios css ON cs.id = css.id_centro_salud
    LEFT JOIN servicios s ON css.id_servicio = s.id
    GROUP BY cs.id
";
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