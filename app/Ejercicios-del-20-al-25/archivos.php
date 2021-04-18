<?php


function guardar_CSV($path, $dato)
{
    $archivoAux = fopen($path, 'a');
    fwrite($archivoAux, "$dato->_nombre,$dato->_mail,$dato->_clave" . PHP_EOL);
    fclose($archivoAux);
}

function leer_CSV($archivoCSV)
{

    $arrayUsuarios = array();
    $archivo = fopen($archivoCSV, 'r');

    while (!(feof($archivo))) {
        $linea = fgets($archivo);
        if (!empty($linea)) {
            array_push($arrayUsuarios, explode(",", $linea));
        }
    }
    fclose($archivo);

    return $arrayUsuarios;
}

function Leer_Json($path, &$array)
    {
        $retorno = false;
        if(file_exists($path) && filesize($path) > 0)
        {
            $archivo = fopen($path, 'r');
            $array = fread($archivo, filesize($path));
            $cerrar = fclose($archivo);
            $array = json_decode($array, true);
            $retorno = true;
        }
        else
        {
            $array = array();
        }
        return $retorno;

    }

function Guardar_Json($dato, $path)
{
    $ret = false;
    

    if (Leer_Json($path, $array)) 
    {
        array_push($array, $dato);
        $aux = json_encode($array, true);
    } else {
        array_push($array, $dato);
        $aux = json_encode($array, true);
    }

    $archivo = fopen($path, 'w');
    if (fwrite($archivo, $aux)) {
        $ret = true;
    }
    fclose($archivo);

    return $ret;
}

function Reescribir_Json($dato, $path)
    {
        $retorno = false;
        $archivo = fopen($path, 'w');
        if(fwrite($archivo, json_encode($dato, true)))
        {
            $retorno = true;
        }
        fclose($archivo);
        return $retorno;
    }



?>