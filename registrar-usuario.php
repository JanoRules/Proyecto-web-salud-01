<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rut = $_POST['rut'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $password = $_POST['password'];
    $correo = $_POST['correo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $ubicacion = $_POST['ubicacion'];
    $estado_salud = $_POST['estado_salud'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO usuario (rut, nombre, apellido, password, correo, fecha_nacimiento, ubicacion, estado_salud) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    try {
        // Ejecutar la consulta
        $stmt->execute([$rut, $nombre, $apellido, $password, $correo, $fecha_nacimiento, $ubicacion, $estado_salud]);
        echo "Usuario registrado exitosamente";
    } catch(PDOException $e) {
        echo "Error en el registro: " . $e->getMessage();
    }
}
?>
