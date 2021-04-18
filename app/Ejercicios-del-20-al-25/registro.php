<?php

include "Usuario.php";
include_once "archivos.php";
$nombre=$_POST["txtNombre"];
$mail=$_POST["txtMail"];
$clave=$_POST["txtClave"];


if((isset($nombre)== true) && (isset($mail)== true) && (isset($clave)== true))
{
    $usuario= new Usuario($clave,$mail,$nombre);
    $usuario->guardarCSV();
    $ubicacionfoto=".\\Usuarios\\Fotos\\". $_FILES['foto']['name'];
    if (isset($_FILES['foto'])) 
    {
        move_uploaded_file($_FILES['foto']['tmp_name'],$ubicacionfoto);
        $usuario->SetImagen($ubicacionfoto);
    }

    Guardar_Json($usuario,"usuarios.json");

    

    echo"Registrado con exito";
    echo "<br/>";
    echo $usuario->ToString();
    
}else
{
 echo "Faltan cargar datos";
}








?>