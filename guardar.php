<?php
// Conexión a la base de datos
$servername = "localhost"; // Puede ser diferente en otros servidores
$username = "root"; // Usuario predeterminado en XAMPP
$password = ""; // Contraseña predeterminada en XAMPP (puede estar en blanco)
$dbname = "Taller_integracion_1"; // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario
$nombre = $_POST['nombre'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$fechaNacimiento = $_POST['fechaNacimiento'] ?? '';
$ubicacion = $_POST['ubicacion'] ?? '';
$correo = $_POST['correo'] ?? ''; // Asegúrate de que este campo esté en el formulario
$rut = $_POST['rut'] ?? '';
// Hash de la contraseña
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Preparar la consulta SQL para insertar los datos
$sql = "INSERT INTO usuarios (nombre, apellidos, username, password, fechaNacimiento, ubicacion, correo, rut) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// Verificar si la preparación de la sentencia fue exitosa
if ($stmt === false) {
    die("Error al preparar la sentencia: " . $conn->error);
}

// Vincular los parámetros
$stmt->bind_param('ssssssss', $nombre, $apellidos, $username, $hashed_password, $fechaNacimiento, $ubicacion, $correo, $rut);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Redirigir a la página de inicio de sesión
    header("Location: login2.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
