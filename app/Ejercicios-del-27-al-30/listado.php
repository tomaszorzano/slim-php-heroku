<?php
include_once "AccesoDatos.php";
include_once "Usuario.php";


$listado=$_GET['listado'];
$arrayLista=array();

if (isset($listado)) 
{
    switch ($listado) 
    {
        case 'usuarios':
            $arrayLista= Usuario::TraerTodoLosUsuarios();
            echo "<ul>";
            foreach ($arrayLista as $usuario)
            {
                
                echo "<li>" . $usuario->mostrarDatos() . "</li>";
            }
            echo "<ul>";    
            break;
        
        default:
            
            break;
    }
}else{
    echo "listado no valido";
}








?>