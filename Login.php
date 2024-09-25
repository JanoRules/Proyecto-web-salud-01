<?php
// Reportar todos los errores y mostrarlos
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); // Iniciar la sesión para poder usar $_SESSION

// Conexión a la base de datos
$servername = "localhost";
$username_db = "root"; // Cambia esto si tienes un usuario diferente
$password_db = ""; // Cambia esto si tienes una contraseña
$dbname = "taller_integracion_1"; // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario
$usuario = $_POST['username'] ?? ''; 
$password = trim($_POST['password'] ?? '');


// Verificar que el nombre de usuario y la contraseña no estén vacíos
if (empty($usuario) || empty($password)) {
echo "No se recibieron los datos correctamente.<br>";
    var_dump($_POST);
    die("Usuario y contraseña son requeridos.");
}

// Preparar la consulta SQL para seleccionar el usuario
$sql = "SELECT username, password FROM usuarios WHERE username = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error al preparar la sentencia: " . $conn->error);
}

$stmt->bind_param('s', $usuario);
$stmt->execute();
$result = $stmt->get_result();
// Verificar si el usuario existe
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    
// Verificar la contraseña ingresada usando password_verify
    if (password_verify($password, $row['password'])) {
        // Contraseña correcta
        echo "Inicio de sesion completado con éxito. Redirigiendo a la pagina principal....";
        $_SESSION['usuario'] = $row['username']; // Guardar el usuario en la sesión
        header("Refresh: 3; url= websalud.html"); // Redirigir a la página principal
        exit();
    } 
	else {
        // Contraseña incorrecta
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no existe.";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
