<?php
$usuario=$_POST['usuario'];
$contraseña=$_POST['contraseña'];
session_start();
$_SESSION['usuario']=$usuario;

$conexion=mysqli_connect("localhost","root","","chefmanagement");

$consulta="SELECT*FROM usuarios where usuario='$usuario' and contraseña='$contraseña'";
$resultado=mysqli_query($conexion,$consulta);

$filas=mysqli_fetch_array($resultado);

if(isset($filas['id_cargo'])) {
    if($filas['id_cargo'] == 1) { // administrador
        header("Location: admin.php");
        exit;
    } elseif($filas['id_cargo'] == 2) { // chef
        header("Location: chef.php");
        exit;
    }
} else {
    echo "ERROR EN LA AUTENTIFICACION";
}

mysqli_free_result($resultado);
mysqli_close($conexion);
