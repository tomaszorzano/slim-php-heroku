<?php
include "Usuario.php";
include_once "archivos.php";


$listado=$_GET["listado"];

$correcto = "si";


if(isset($listado) == true)
{
    
    switch ($listado) 
    {
        
        case 'usuarios':

            /*$arrayuser = Usuario::leerCSV("usuarios.csv");
            echo Usuario:: listar($arrayuser);*/

            
            $arrayuser= array();
            Leer_Json("usuarios.json",$arrayuser);
            Usuario:: listar($arrayuser);
         
            break;
        
        default:
            $correcto="no";
            break;
    }

    if ($correcto == "no")
    {
        echo "No hay listado";
    }

}else
{
    echo "No cargo el parametro";
}







?>