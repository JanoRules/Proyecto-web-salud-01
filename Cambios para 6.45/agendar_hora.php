<?php
// Conexión a la base de datos (ajusta los valores con los de tu entorno)
$host = 'localhost';
$db = 'base_datos'; // Nombre de la base de datos
$user = 'root'; // Usuario de la base de datos
$pass = ''; // Contraseña
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Limpia el buffer de salida para evitar caracteres extra
ob_clean();

// Obtener los datos enviados desde el fetch (JSON)
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['idCentro']) && isset($data['fecha']) && isset($data['hora'])) {
    $idCentro = $data['idCentro'];
    $fecha = $data['fecha'];
    $hora = $data['hora'];

    // Inserción en la base de datos
    $sql = "INSERT INTO agendar_hora (id_centro, fecha, hora) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$idCentro, $fecha, $hora])) {
        // Obtener el nombre del centro para la respuesta
        $centroSql = "SELECT nombre FROM centros WHERE id = ?";
        $centroStmt = $pdo->prepare($centroSql);
        $centroStmt->execute([$idCentro]);
        $centro = $centroStmt->fetch();

        echo json_encode(['success' => true, 'centro' => $centro['nombre']]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
}
?>


