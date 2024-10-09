<?php
include 'conexion.php'; // Incluir el archivo de conexión
echo "<link rel='stylesheet' href='register.css'>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si es un formulario de registro o reseña
    if (isset($_POST['rut'])) { // Registro de usuario
        // Recibir los datos del formulario de registro
        $rut = $_POST['rut'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
        $fechaNacimiento = $_POST['fechaNacimiento'];
        $ubicacion = $_POST['ubicacion'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

        // Insertar datos en la tabla 'registro'
        $sql_registro = "INSERT INTO registro (rut, nombre, apellidos, correo, fechaNacimiento, ubicacion)
                         VALUES ('$rut', '$nombre', '$apellidos', '$correo', '$fechaNacimiento', '$ubicacion')";

        if ($conn->query($sql_registro) === TRUE) {
            // Si se inserta correctamente en 'registro', insertar en 'login'
            $sql_login = "INSERT INTO login (rut, username, password)
                          VALUES ('$rut', '$username', '$password')";

            if ($conn->query($sql_login) === TRUE) {
                // Estilo para el mensaje de éxito y el botón
                echo "<div style='text-align: center; margin-top: 50px;'>";
                echo "<p style='color: green; font-size: 18px;'>¡Registro exitoso! Ya puedes iniciar sesión.</p>";
                echo "<a href='login2.html'>
                        <button style='padding: 15px 30px; font-size: 18px; background-color: #007bff; color: white; border: none; border-radius: 8px; cursor: pointer;'>Iniciar Sesión</button>
                      </a>";
                echo "</div>";
            } else {
                echo "Error al crear el login: " . $conn->error;
            }
        } else {
            echo "Error al registrar los datos: " . $conn->error;
        }
    } elseif (isset($_POST['reseña'])) { // Envío de reseña
        $usuario = $_POST['usuario']; // Suponiendo que este campo está en tu formulario
        $reseña = $_POST['reseña']; // Suponiendo que este campo está en tu formulario

        // Insertar la reseña en la tabla correspondiente
        $sql_reseña = "INSERT INTO reseñas (usuario, reseña) VALUES ('$usuario', '$reseña')";

        if ($conn->query($sql_reseña) === TRUE) {
            echo "¡Gracias por tu reseña!";
        } else {
            echo "Error al guardar la reseña: " . $conn->error;
        }
    }

    $conn->close();
}
?>
