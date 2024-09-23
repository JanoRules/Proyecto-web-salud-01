<?php
include 'conexion.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
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
            echo "Registro y login creados exitosamente!";
            // Aquí agregamos el botón para redirigir a login2.html
            echo "<br><br><a href='login2.html'><button>Iniciar Sesión</button></a>";
        } else {
            echo "Error al crear el login: " . $conn->error;
        }
    } else {
        echo "Error al registrar los datos: " . $conn->error;
    }

    $conn->close();
}
?>
