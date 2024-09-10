<?php
include('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rut = $_POST['rut'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $password = $_POST['password'];
    $correo = $_POST['correo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $ubicacion = $_POST['ubicacion'];
    $estado_salud = $_POST['estado_salud'];

    // Insertar datos en la tabla de usuario
    $sql = "INSERT INTO usuario (rut, nombre, apellido, password, correo, fecha_nacimiento, ubicacion, estado_salud)
            VALUES (:rut, :nombre, :apellido, :password, :correo, :fecha_nacimiento, :ubicacion, :estado_salud)";
    $stmt = $conn->prepare($sql);

    $stmt->execute([
        'rut' => $rut,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'password' => $password,
        'correo' => $correo,
        'fecha_nacimiento' => $fecha_nacimiento,
        'ubicacion' => $ubicacion,
        'estado_salud' => $estado_salud
    ]);

    echo " Usuario registrado con éxito";
}
?>
