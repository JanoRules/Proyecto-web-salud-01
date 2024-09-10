<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>
    <h1>Registro de Usuario</h1>
    <form action="registro_proceso.php" method="POST">
        <input type="text" name="rut" placeholder="RUT" required><br>
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <input type="text" name="apellido" placeholder="Apellido" required><br>
        <input type="password" name="password" placeholder="Contraseña" required><br>
        <input type="email" name="correo" placeholder="Correo" required><br>
        <input type="date" name="fecha_nacimiento" placeholder="Fecha de Nacimiento" required><br>
        <input type="text" name="ubicacion" placeholder="Ubicación" required><br>
        <input type="text" name="estado_salud" placeholder="Estado de Salud" required><br>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>
