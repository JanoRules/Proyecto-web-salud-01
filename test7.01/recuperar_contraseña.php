<?php
include 'conexion.php';
echo "<link rel='stylesheet' href='register.css'>"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $correo = $_POST['correo']; // Cambiado de 'rut' a 'correo'
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); // Encriptar la nueva contraseña

    // Verificar si el usuario y el correo existen en la base de datos
    $sql = "SELECT * FROM login INNER JOIN registro ON login.correo = registro.correo WHERE login.username = '$username' AND registro.correo = '$correo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Actualizar la contraseña en la tabla 'login'
        $sql_update = "UPDATE login SET password = '$new_password' WHERE username = '$username'";

        if ($conn->query($sql_update) === TRUE) {
            echo "<div style='text-align: center; margin-top: 50px;'>";
            echo "<p style='color: green; font-size: 18px;'>¡Contraseña actualizada con éxito! Ya puedes iniciar sesión.</p>";
            echo "<a href='login2.html'>
                    <button style='padding: 15px 30px; font-size: 18px; background-color: #007bff; color: white; border: none; border-radius: 8px; cursor: pointer;'>Iniciar Sesión</button>
                  </a>";
            echo "</div>";
        } else {
            echo "Error al actualizar la contraseña: " . $conn->error;
        }
    } else {
        echo "<p style='color: red; font-size: 18px;'>Usuario o correo electrónico incorrecto.</p>";
    }

    $conn->close();
}
?>
