<?php
include_once "AccesoDatos.php";
include_once "Usuario.php";

$nombre = $_POST['nombre'];
$mail = $_POST['mail'];
$claveVieja = $_POST['clavevieja'];
$claveNueva = $_POST['clavenueva'];

if (
    isset($nombre) &&
    isset($mail) &&
    isset($claveNueva) &&
    isset($claveVieja) ) 

{
    $login=Usuario::Login($mail, $claveVieja);

    if($login == "Usuario Verificado")
    {
        $usuario= new Usuario();
        $usuario->mail=$mail;
        $usuario->clave=$claveNueva;
        $usuario->ModificarUsuariosParametros();
        echo "Usuario modificado";

    }else
    {
        echo $login;
    }


}
