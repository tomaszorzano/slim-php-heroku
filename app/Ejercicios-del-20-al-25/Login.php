<?php
include "Usuario.php";

$mail=$_POST['mail'];
$clave=$_POST['clave'];

if ( (isset($mail)== true) && (isset($clave)== true) )
{
    $usuario = new Usuario($clave,$mail);
    echo Usuario::Login($usuario,"usuarios.csv");
}
else
{
    echo "Datos no ingresados";
}

?>