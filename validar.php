<?php
$nombre=$_POST['nombre'];
$password=$_POST['pass'];
session_start();
$_SESSION['nombre']=$nombre;

$conexion=mysqli_connect("localhost","root","","websalud");

$consulta="SELECT*FROM usuario where nombre='$nombre' and pass='$password'";
$resultado=mysqli_query($conexion,$consulta);

$filas=mysqli_num_rows($resultado);

if($filas){
    header("location:websalud.html");


}else{
    ?>
    <?php
    include("login2.html");
    ?>
    <h1>ERROR EN LA AUTENTIFICACION</h1>
    <?php
}

mysqli_free_result($resultado);
mysqli_close($conexion);


