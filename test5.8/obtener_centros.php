<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "base_datos";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los centros de salud
$sql = "SELECT nombre, lat, lng, atencion, tipo, horario, servicios, reseñas, rating FROM centros_salud";
$result = $conn->query($sql);

$centros = [];

// Verificar si la consulta devolvió resultados
if ($result && $result->num_rows > 0) {
    // Convertir los resultados en un array
    while ($row = $result->fetch_assoc()) {
        $centros[] = $row;
    }
}

// Devolver los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($centros);

// Cerrar la conexión a la base de datos
$conn->close();
?>