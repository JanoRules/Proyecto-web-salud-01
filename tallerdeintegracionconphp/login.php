<?php
// Conexión a la base de datos MySQL usando XAMPP
$servername = "localhost";
$username_db = "root"; // Usuario predeterminado de XAMPP
$password_db = "";     // Sin contraseña por defecto
$dbname = "web";       

// Crear conexión
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Encriptar la contraseña con MD5 (mejor usar password_hash para mayor seguridad)
$password_encrypted = md5($password);

// Verificar si el usuario existe
$sql = "SELECT * FROM login WHERE username='$username' AND password='$password_encrypted'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // El usuario está autenticado correctamente
    echo "Inicio de sesión exitoso. ¡Bienvenido, $username!";
    // Aquí se puede redirigir al usuario a otra página si lo deseas
    // header("Location: dashboard.php");
} else {
    // Usuario o contraseña incorrectos
    echo "Usuario o contraseña incorrectos";
}

// Cerrar conexión
$conn->close();
?>
