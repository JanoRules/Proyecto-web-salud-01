<?php
include 'conexion.php';

try {
    // Preparar la consulta para obtener los centros de salud
    $sql = "SELECT * FROM centro_salud";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obtener los resultados y mostrarlos
    $centros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Centros de Salud Registrados</h2>";
    foreach ($centros as $centro) {
        echo "ID: " . $centro['Id_centro_salud'] . " - Nombre: " . $centro['nombre'] . " - Dirección: " . $centro['direccion'] . "<br>";
    }
} catch(PDOException $e) {
    echo "Error al listar los centros de salud: " . $e->getMessage();
}
?>
