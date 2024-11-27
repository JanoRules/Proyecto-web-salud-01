<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'conexion.php';

header('Content-Type: application/json');

try {
    if (!isset($pdo) || !$pdo) {
        throw new Exception('Error en la conexión a la base de datos.');
    }

    $centroSaludId = isset($_GET['centro_salud_id']) ? (int)$_GET['centro_salud_id'] : 0;

    if ($centroSaludId > 0) {
        $sql = "SELECT p.nombre, p.especialidad, p.tipo, p.disponibilidad, c.nombre AS centro_salud 
                FROM personal_centro_salud p
                JOIN centros_salud c ON p.centro_salud_id = c.id
                WHERE c.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$centroSaludId]);

        $personal = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($personal) {
            echo json_encode($personal);
        } else {
            echo json_encode(['message' => 'No se encontró personal asociado.']);
        }
    } else {
        echo json_encode(['error' => 'ID de centro de salud no válido.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>

