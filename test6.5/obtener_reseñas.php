<?php
// obtener_reseñas.php
header('Content-Type: application/json');

// Conexión a la base de datos
$servername = "localhost"; // Cambia por tu servidor
$username = "root"; // Cambia por tu usuario
$password = ""; // Cambia por tu contraseña
$dbname = "base_datos"; // Cambia por tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del centro de salud desde la URL
$centro_salud_id = isset($_GET['centro_salud_id']) ? intval($_GET['centro_salud_id']) : 0;

// Consulta para obtener las reseñas del centro de salud especificado
$sql = "SELECT nombre, centro_salud, calificacion, reseña, fecha FROM reseñas 
        WHERE centro_salud_id = ? 
        ORDER BY fecha DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $centro_salud_id);
$stmt->execute();
$result = $stmt->get_result();

$reseñas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reseñas[] = $row;
    }
}

// Devolver las reseñas en formato JSON
echo json_encode($reseñas);

$stmt->close();
$conn->close();
?>
