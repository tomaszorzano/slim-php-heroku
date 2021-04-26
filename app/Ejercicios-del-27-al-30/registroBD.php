<?php
include_once "AccesoDatos.php";
include_once "Usuario.php";

//$id=$_POST['id'];
$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$clave=$_POST['clave'];
$mail=$_POST['mail'];
$fecha=$_POST['fecha'];
$localidad=$_POST['localidad'];

if (
    isset($nombre) &&  
    isset($apellido) && 
    isset($clave) && 
    isset($mail) && 
    isset($fecha) && 
    isset($localidad)) 
{
    $usuario= new Usuario();

    //$usuario->id=$id;
    $usuario->nombre=$nombre;
    $usuario->apellido=$apellido;
    $usuario->clave=$clave;
    $usuario->mail=$mail;
    $usuario->fecha_de_registro=$fecha;
    $usuario->localidad=$localidad;

    $ultimoID=$usuario->InsertarElUsuarioParametros();

    echo "ultimo id:". $ultimoID;
    
}
